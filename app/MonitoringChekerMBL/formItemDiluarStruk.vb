Imports Oracle.DataAccess.Client
Imports Microsoft.Office.Interop
Imports System.Windows.Forms

Public Class frmItemDiluarStruk

    Dim sql As String
    Dim _dt As New DataTable
    Dim flagProcess As Boolean = False

    Private Sub btnShow_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnShow.Click

        _dt = New DataTable
        _dt = QueryOra(getQuery)
        Application.DoEvents()

        dgv.DataSource = _dt
        dgv.Refresh()

        If _dt.Rows.Count = 0 Then
            MsgBox("tidak ada data.")
        End If

    End Sub

    Private Sub btnExport_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnExport.Click

        If txtPath.Text = Nothing Then
            MsgBox("Pilih path terlebih dahulu")
            Exit Sub
        End If

        Console.WriteLine("Process Start : " & Date.Now)
        Try
            _dt = New DataTable
            _dt = QueryOra(getQuery)

            If _dt.Rows.Count > 0 Then
                If flagProcess = False Then

                    flagProcess = True
                    labelStatus.Text = "Ekspor Data..."
                    Application.DoEvents()

                    Dim lblTanggal As String = dtPick1.Value.ToString("ddMMyy")

                    Dim strFileName As String
                    If Strings.Right(txtPath.Text, 1) = "\" Then
                        strFileName = txtPath.Text & "ITEM DILUAR STRUK " & WS_KodeCabang & " " & lblTanggal & ".xlsx"
                    Else
                        strFileName = txtPath.Text & "\ITEM DILUAR STRUK " & WS_KodeCabang & " " & lblTanggal & ".xlsx"
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

                    MsgBox("Selesai! File disimpan di " & strFileName)

                Else
                    MsgBox("masih ada proses yang berjalan!")
                End If
            Else
                MsgBox("Tidak ada data!")
            End If

        Catch ex As Exception
            labelStatus.Text = ""
            MsgBox(ex.ToString, MsgBoxStyle.Critical)
        Finally
            labelStatus.Text = ""
            Console.WriteLine("Process End : " & Date.Now)
            flagProcess = False
        End Try
    End Sub

    Private Sub frmItemDiluarStruk_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        labelStatus.Text = ""
    End Sub

    Private Function getQuery() As String
        sql = "SELECT CHECKER_ID, PRDCD AS KODEPLU, NAMA_BARANG, "
        sql += "QTY, TRANSACTIONDATE TGL_TRANS, CASHIERID KASIR, CASHIERSTATION STATION, "
        sql += " TRANSACTIONNO NO_TRANS, MEMBERCODE KODE_MEMBER,  "
        sql += "(SELECT CUS_NAMAMEMBER FROM TBMASTER_CUSTOMER WHERE CUS_KODEMEMBER = MEMBERCODE) NAMA_MEMBER "
        sql += "FROM TBTR_ITEM_CHECKER "
        sql += "WHERE TRUNC(TRANSACTIONDATE) = TO_DATE('" & dtPick1.Value.ToString("dd-MM-yyyy") & "','dd-MM-yyyy') "
        sql += "ORDER BY TRANSACTIONDATE ASC "

        Return sql
    End Function

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

    Private Sub btnPath_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnPath.Click
        If FolderBrowserDialog1.ShowDialog = Windows.Forms.DialogResult.OK Then
            txtPath.Text = FolderBrowserDialog1.SelectedPath
        End If
    End Sub
End Class