Imports System.Data.Odbc
Imports Microsoft.Office.Interop
Imports System.Windows.Forms

Public Class frmEkspor

    Dim _date As Date
    Dim _desc As String
    Dim _dt As DataTable
    Dim _flagProses As Boolean = False
    Dim _sql As String

    Public WriteOnly Property setDate()
        Set(ByVal value)
            _date = value
        End Set
    End Property

    Public WriteOnly Property setDesc()
        Set(ByVal value)
            _desc = value
        End Set
    End Property

    Private Sub frmEkspor_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        labelTanggal.Text = _date.ToString("dd-MM-yyyy")
        labelHeaderText.Text = "Ekspor Data " & _desc.ToString & " ke Excel"
    End Sub

    Private Sub btnPath_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnPath.Click
        If FolderBrowserDialog1.ShowDialog = Windows.Forms.DialogResult.OK Then
            txtPath.Text = FolderBrowserDialog1.SelectedPath
        End If
    End Sub

    Private Sub btnExport_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnExport.Click
        If txtPath.Text <> Nothing Then
            If MsgBox("Ekspor data tanggal : " & labelTanggal.Text & "?", MsgBoxStyle.YesNo) = MsgBoxResult.Yes Then
                If _flagProses = False Then

                    _flagProses = True

                    Console.WriteLine("Process Start : " & Date.Now)
                    Try
                        _sql = "select to_char(h.transactiondate,'dd-MM-yyyy') TANGGAL, to_char(h.transactiondate,'HH24:MI:SS') JAM, "
                        _sql += "h.membercode MEMBER, h.cashierid KASIR, h.cashierstation STATION, h.transactionno NOTRANS,h.checkerid CHECKER, "
                        _sql += "case h.priority when '1' then 'DRAFT STRUK' else 'REGULER' end PRIORITAS, d.kodeplu PLU, p.prd_deskripsipanjang DESKRIPSI, "
                        _sql += "p.prd_unit UNIT, p.prd_frac FRAC, "
                        _sql += "d.qtyorder QTY_ORDER, d.qtyreal QTY_REAL, d.keterangan KETERANGAN, d.referensi REFERENSI "
                        _sql += "from tbtr_checker_header h join tbtr_checker_detail d  "
                        _sql += "on to_char(h.transactiondate,'YYYYMMDD') || h.cashierid || h.cashierstation || h.transactionno = d.nostruk  "
                        _sql += "join tbmaster_prodmast p "
                        _sql += "on d.kodeplu = p.prd_prdcd "
                        _sql += "where trunc(h.transactiondate) = TO_DATE('" & _date.ToString("dd-MM-yyyy") & "','dd-MM-yyyy') "
                        If _desc = "LEBIH" Then
                            '_sql += "and d.keterangan like 'Dibayar%'  or d.keterangan like 'Dikembalikan%' "
                            _sql += "and d.qtyreal > d.qtyorder "
                        ElseIf _desc = "KURANG" Then
                            '_sql += "and d.keterangan like 'Diambil%'  or d.keterangan like 'Direfund%' "
                            _sql += "and d.qtyreal < d.qtyorder "
                        End If
                        _sql += "order by h.cashierid, h.transactionno "

                        _dt = New DataTable
                        _dt = QueryOra(_sql)
                        If _dt.Rows.Count > 0 Then

                            pBar.Value = 0
                            pBar.Maximum = _dt.Rows.Count
                            labelStatus.Text = "Ekspor Data..."

                            Dim strFileName As String
                            If Strings.Right(txtPath.Text, 1) = "\" Then
                                strFileName = txtPath.Text & "MONITORING CHECKER " & WS_KodeCabang & " " & labelTanggal.Text & "-" & _desc & ".xlsx"
                            Else
                                strFileName = txtPath.Text & "\MONITORING CHECKER " & WS_KodeCabang & " " & labelTanggal.Text & "-" & _desc & ".xlsx"
                            End If


                            'Dim strFileName As String = filepath
                            If System.IO.File.Exists(strFileName) Then
                                If (MessageBox.Show("Do you want to replace from the existing file?", "Export to Excel", _
                                                    MessageBoxButtons.YesNo, _
                                                    MessageBoxIcon.Question, _
                                                    MessageBoxDefaultButton.Button2) = System.Windows.Forms.DialogResult.Yes) Then
                                    System.IO.File.Delete(strFileName)
                                Else
                                    Return
                                End If

                            End If
                            Dim xlApp As New Excel.Application
                            Dim wBook As Excel.Workbook
                            Dim wSheet As Excel.Worksheet

                            Dim misValue As Object = System.Reflection.Missing.Value
                            Dim oldCI As System.Globalization.CultureInfo = System.Threading.Thread.CurrentThread.CurrentCulture
                            System.Threading.Thread.CurrentThread.CurrentCulture = New System.Globalization.CultureInfo("en-US")

                            xlApp = New Excel.ApplicationClass()
                            wBook = xlApp.Workbooks.Add(misValue)


                            'wBook = _excel.Workbooks.Add()
                            wSheet = wBook.ActiveSheet()

                            Dim dt As System.Data.DataTable = _dt
                            Dim dc As System.Data.DataColumn
                            Dim dr As System.Data.DataRow
                            Dim colIndex As Integer = 0
                            Dim rowIndex As Integer = 0
                            Dim formatRange As Excel.Range

                            For Each dc In dt.Columns
                                colIndex = colIndex + 1
                                wSheet.Cells(1, colIndex) = dc.ColumnName
                            Next


                            For Each dr In dt.Rows
                                rowIndex = rowIndex + 1
                                colIndex = 0

                                'Dim startFormat As String = "C2"
                                'Dim endFormat As String = "H" & dt.Rows.Count + 1
                                formatRange = wSheet.Range("C:I")
                                formatRange.NumberFormat = "@"

                                'Console.WriteLine(rowIndex)

                                For Each dc In dt.Columns
                                    colIndex = colIndex + 1
                                    wSheet.Cells(rowIndex + 1, colIndex) = dr(dc.ColumnName)
                                Next
                                pBar.Value += 1
                                Application.DoEvents()
                            Next
                            wSheet.Columns.AutoFit()
                            wBook.SaveAs(strFileName)

                            releaseObject(wSheet)
                            wBook.Close(False)
                            releaseObject(wBook)
                            xlApp.Quit()
                            releaseObject(xlApp)
                            GC.Collect()

                            labelStatus.Text = "Done!"
                            MsgBox("Selesai! File disimpan di " & strFileName)
                            pBar.Value = 0
                        Else
                            MsgBox("Tidak ada data")
                        End If

                    Catch ex As Exception
                        labelStatus.Text = "Ready!"
                        MsgBox(ex.ToString, MsgBoxStyle.Critical)
                    Finally
                        Console.WriteLine("Process End : " & Date.Now)
                        _flagProses = False
                    End Try

                Else
                    MsgBox("Masih ada proses yang berjalan")
                End If
            End If
        End If
    End Sub

    Private Sub btnBatal_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnBatal.Click
        Me.Close()
    End Sub

    Private Sub releaseObject(ByVal obj As Object)
        Try
            System.Runtime.InteropServices.Marshal.ReleaseComObject(obj)
            obj = Nothing
        Catch ex As Exception
            obj = Nothing
        Finally
            GC.Collect()
        End Try
    End Sub
End Class