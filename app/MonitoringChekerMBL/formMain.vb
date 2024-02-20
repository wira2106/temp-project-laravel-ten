Imports System.Data.Odbc

Public Class frmMain

    Dim cn As New OdbcConnection
    Dim dt As New DataTable
    Dim cmd As New OdbcCommand
    Dim flagProcess As Boolean = False
    Dim sql As String
    Dim selectedChecker As String

    Private Sub frmMain_FormClosing(ByVal sender As Object, ByVal e As System.Windows.Forms.FormClosingEventArgs) Handles Me.FormClosing
        If flagProcess Then
            e.Cancel = True
            MsgBox("Masih ada proses yang berjalan.")
        End If
    End Sub

    Private Sub Form1_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        cn = KoneksiOra()
        cbFilter.SelectedIndex = 0
    End Sub

    Private Sub frmMain_Shown(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Shown
        Dim login As New frmLogin
        login.ShowDialog()
        If login.isValid = False Then
            Me.Close()
        End If

        labelKoneksi.Text = WS_KodeCabang & " (" & WS_JenisServer & ")"
        ToolStripStatusUser.Text = "USER : " & UserMODUL & " # IP : " & IPMODUL & " # VERSION : " & Version
    End Sub

    Private Sub isiData()
        Dim Lvitem As New ListViewItem
        lvData.Items.Clear()
        dgv1.DataSource = Nothing
        dgv1.Refresh()
        dgv2.DataSource = Nothing
        dgv2.Refresh()

        flagProcess = True

        Try
            'sql = "SELECT NVL(CHECKERID,'BELUM CHECKER') CHECKER, COUNT(TRANSACTIONNO) TOTAL "
            'sql += "FROM TBTR_CHECKER_HEADER "
            'sql += "WHERE TRUNC(TRANSACTIONDATE) = TO_DATE('" & dtPick.Value.ToString("dd-MM-yyyy") & "','dd-MM-RRRR') "
            'sql += "GROUP BY CHECKERID "
            'sql += "ORDER BY CHECKERID "

            If cbFilter.SelectedIndex = 0 Then
                sql = "select checker as id, count(distinct struk) total,  sum(selisih) selisih  from (  "
                sql += "SELECT NVL(CHECKERID,'BELUM CHECKER') CHECKER, TRANSACTIONNO || CASHIERID struk,  "
                sql += "CASE WHEN d.qtyorder <> d.qtyreal then 1 else 0 end selisih  "
                sql += "FROM TBTR_CHECKER_HEADER h JOIN TBTR_CHECKER_DETAIL d  "
                sql += "ON to_char(h.transactiondate,'RRRRMMDD') || h.cashierid || h.cashierstation || h.transactionno = d.nostruk  "
                sql += "WHERE TRUNC(TRANSACTIONDATE) = TO_DATE('" & dtPick.Value.ToString("dd-MM-yyyy") & "','dd-MM-RRRR')  "
                sql += "ORDER BY CHECKERID) group by checker order by selisih desc "
            Else
                sql = "select cashier as id, count(distinct struk) total,  sum(selisih) selisih  from (  "
                sql += "SELECT CASHIERID CASHIER, TRANSACTIONNO || CASHIERID struk,  "
                sql += "CASE WHEN d.qtyorder <> d.qtyreal then 1 else 0 end selisih  "
                sql += "FROM TBTR_CHECKER_HEADER h JOIN TBTR_CHECKER_DETAIL d  "
                sql += "ON to_char(h.transactiondate,'RRRRMMDD') || h.cashierid || h.cashierstation || h.transactionno = d.nostruk  "
                sql += "WHERE TRUNC(TRANSACTIONDATE) = TO_DATE('" & dtPick.Value.ToString("dd-MM-yyyy") & "','dd-MM-RRRR')  "
                sql += "ORDER BY CASHIERID) group by CASHIER order by selisih desc "

            End If

         
            dt = New DataTable
            dt = QueryOra(sql)

            If dt.Rows.Count > 0 Then

                For i = 0 To dt.Rows.Count - 1
                    Lvitem = lvData.Items.Add(dt.Rows(i)("ID"))
                    Lvitem.SubItems.Add(dt.Rows(i)("TOTAL").ToString)
                    Lvitem.SubItems.Add(dt.Rows(i)("SELISIH").ToString)

                    If i Mod 2 = 0 Then
                        lvData.Items(i).BackColor = Color.Aquamarine
                    End If

                Next

                'lvData.AutoResizeColumns(ColumnHeaderAutoResizeStyle.ColumnContent)
                For Each column As ColumnHeader In lvData.Columns
                    column.Width = -2
                Next

            Else
                MsgBox("Tidak ada data")
            End If
        Catch ex As Exception
            MsgBox(ex.ToString, MsgBoxStyle.Critical)
        Finally
            flagProcess = False
        End Try

    End Sub

    Private Sub btnShow_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnShow.Click
        isiData()
    End Sub

    Private Sub lvData_ItemCheck(ByVal sender As Object, ByVal e As System.Windows.Forms.ItemCheckEventArgs) Handles lvData.ItemCheck
        If lvData.Items.Count > 0 And flagProcess = False Then
            If e.NewValue = CheckState.Checked Then
                For i = 0 To lvData.Items.Count - 1
                    lvData.Items(i).Checked = False
                Next
            End If

        End If
    End Sub

    Private Sub lvData_ItemChecked(ByVal sender As Object, ByVal e As System.Windows.Forms.ItemCheckedEventArgs) Handles lvData.ItemChecked
        If lvData.Items.Count > 0 And flagProcess = False Then

            If lvData.Items(e.Item.Index).Checked = True Then
                selectedChecker = lvData.Items(e.Item.Index).Text

                If selectedChecker <> "BELUM CHECKER" Then

                    flagProcess = True

                    'load data using checker
                    Try
                        'sql = "SELECT TRANSACTIONNO NOTRANS, CASHIERID KASIR, CASHIERSTATION STATION, "
                        'sql += "MEMBERCODE MEMBER, TO_CHAR(CHECKERDATE,'HH24:MI:SS') JAM, "
                        'sql += "CASE FLAG WHEN 'N' THEN 'BARU' WHEN 'C' THEN 'PROSES' WHEN 'Y' THEN 'SELESAI' WHEN 'P' THEN 'PENDING' END STATUS "
                        'sql += "FROM TBTR_CHECKER_HEADER "
                        'sql += "WHERE TRUNC(TRANSACTIONDATE) = TO_DATE('" & dtPick.Value.ToString("dd-MM-yyyy") & "','dd-MM-RRRR') "
                        'sql += "AND CHECKERID = '" & selectedChecker & "' "
                        'sql += "ORDER BY CHECKERDATE "

                        If cbFilter.SelectedIndex = 0 Then
                            sql = " select NOTRANS, KASIR,  STATION, MEMBER, JAM, STATUS, case when sum(selisih) > 0 then 1 else 0 end selisih  from (  "
                            sql += " SELECT TRANSACTIONNO NOTRANS, CASHIERID KASIR, CASHIERSTATION STATION,   "
                            sql += " MEMBERCODE MEMBER, TO_CHAR(CHECKERDATE,'HH24:MI:SS') JAM,   "
                            sql += " CASE FLAG WHEN 'N' THEN 'BARU' WHEN 'C' THEN 'PROSES' WHEN 'Y' THEN 'SELESAI' WHEN 'P' THEN 'PENDING' END STATUS,  "
                            sql += " CASE WHEN d.qtyorder <> d.qtyreal then 1 else 0 end selisih  "
                            sql += " FROM TBTR_CHECKER_HEADER h JOIN TBTR_CHECKER_DETAIL d  "
                            sql += " ON to_char(h.transactiondate,'RRRRMMDD') || h.cashierid || h.cashierstation || h.transactionno = d.nostruk  "
                            sql += "WHERE TRUNC(TRANSACTIONDATE) = TO_DATE('" & dtPick.Value.ToString("dd-MM-yyyy") & "','dd-MM-RRRR') "
                            sql += "AND CHECKERID = '" & selectedChecker & "' "
                            sql += " ORDER BY CHECKERDATE) GROUP BY NOTRANS, KASIR,  STATION, MEMBER, JAM, STATUS order by 7 desc "
                        Else
                            sql = " select NOTRANS, KASIR,  STATION, MEMBER, JAM, STATUS, case when sum(selisih) > 0 then 1 else 0 end selisih  from (  "
                            sql += " SELECT TRANSACTIONNO NOTRANS, CASHIERID KASIR, CASHIERSTATION STATION,   "
                            sql += " MEMBERCODE MEMBER, TO_CHAR(CHECKERDATE,'HH24:MI:SS') JAM,   "
                            sql += " CASE FLAG WHEN 'N' THEN 'BARU' WHEN 'C' THEN 'PROSES' WHEN 'Y' THEN 'SELESAI' WHEN 'P' THEN 'PENDING' END STATUS,  "
                            sql += " CASE WHEN d.qtyorder <> d.qtyreal then 1 else 0 end selisih  "
                            sql += " FROM TBTR_CHECKER_HEADER h JOIN TBTR_CHECKER_DETAIL d  "
                            sql += " ON to_char(h.transactiondate,'RRRRMMDD') || h.cashierid || h.cashierstation || h.transactionno = d.nostruk  "
                            sql += "WHERE TRUNC(TRANSACTIONDATE) = TO_DATE('" & dtPick.Value.ToString("dd-MM-yyyy") & "','dd-MM-RRRR') "
                            sql += "AND CASHIERID = '" & selectedChecker & "' "
                            sql += " ORDER BY CHECKERDATE) GROUP BY NOTRANS, KASIR,  STATION, MEMBER, JAM, STATUS order by 7 desc "
                        End If

                   

                        dt = New DataTable
                        dt = QueryOra(sql)
                        If dt.Rows.Count > 0 Then
                            dgv1.DataSource = dt

                            For i = 0 To dgv1.Rows.Count - 1
                                If Val(dgv1.Rows(i).Cells(6).Value) > 0 Then
                                    dgv1.Rows(i).DefaultCellStyle.BackColor = Color.MistyRose
                                End If
                            Next

                            dgv1.Refresh()
                        End If

                    Catch ex As Exception
                        MsgBox(ex.ToString, MsgBoxStyle.Critical)
                    Finally
                        flagProcess = False
                    End Try


                End If

            Else
                selectedChecker = Nothing
                dgv1.DataSource = Nothing
                dgv1.Refresh()
                dgv2.DataSource = Nothing
                dgv2.Refresh()
            End If

        End If

    End Sub

    Private Sub dgv1_CellDoubleClick(ByVal sender As Object, ByVal e As System.Windows.Forms.DataGridViewCellEventArgs) Handles dgv1.CellDoubleClick
        If dgv1.RowCount > 0 Then
            If dgv1.Item(5, dgv1.CurrentCell.RowIndex).Value <> "PROSES" Then
                If flagProcess = False Then

                    flagProcess = True
                    Try
                        If cbFilter.SelectedIndex = 0 Then
                            sql = "select rownum no, b.* from ("
                            sql += "select d.kodeplu PLU, p.prd_deskripsipanjang DESKRIPSI, "
                            sql += "p.prd_unit UNIT, p.prd_frac FRAC, "
                            sql += "d.qtyorder QTY_ORDER, d.qtyreal QTY_REAL, ABS(d.qtyorder-d.qtyreal) SELISIH, d.keterangan KETERANGAN, d.referensi REFERENSI "
                            sql += "from tbtr_checker_header h join tbtr_checker_detail d  "
                            sql += "on to_char(h.transactiondate,'RRRRMMDD') || h.cashierid || h.cashierstation || h.transactionno = d.nostruk  "
                            sql += "join tbmaster_prodmast p   "
                            sql += "on d.kodeplu = p.prd_prdcd  "
                            sql += "where checkerid = '" & selectedChecker & "' "
                            sql += "and membercode = '" & dgv1.Item(3, dgv1.CurrentCell.RowIndex).Value & "' "
                            sql += "and transactionno = '" & dgv1.Item(0, dgv1.CurrentCell.RowIndex).Value & "' "
                            sql += "and cashierid = '" & dgv1.Item(1, dgv1.CurrentCell.RowIndex).Value & "' "
                            sql += "and cashierstation = '" & dgv1.Item(2, dgv1.CurrentCell.RowIndex).Value & "' "
                            sql += "ORDER BY 7 DESC) b order by 8 desc "
                        Else
                            sql = "select rownum no, b.* from ("
                            sql += "select d.kodeplu PLU, p.prd_deskripsipanjang DESKRIPSI, "
                            sql += "p.prd_unit UNIT, p.prd_frac FRAC, "
                            sql += "d.qtyorder QTY_ORDER, d.qtyreal QTY_REAL, ABS(d.qtyorder-d.qtyreal) SELISIH, d.keterangan KETERANGAN, d.referensi REFERENSI "
                            sql += "from tbtr_checker_header h join tbtr_checker_detail d  "
                            sql += "on to_char(h.transactiondate,'RRRRMMDD') || h.cashierid || h.cashierstation || h.transactionno = d.nostruk  "
                            sql += "join tbmaster_prodmast p   "
                            sql += "on d.kodeplu = p.prd_prdcd  "
                            sql += "where membercode = '" & dgv1.Item(3, dgv1.CurrentCell.RowIndex).Value & "' "
                            sql += "and transactionno = '" & dgv1.Item(0, dgv1.CurrentCell.RowIndex).Value & "' "
                            sql += "and cashierid = '" & dgv1.Item(1, dgv1.CurrentCell.RowIndex).Value & "' "
                            sql += "and cashierstation = '" & dgv1.Item(2, dgv1.CurrentCell.RowIndex).Value & "' "
                            sql += "ORDER BY 7 DESC) b "
                        End If
                       

                        dt = New DataTable
                        dt = QueryOra(sql)
                        If dt.Rows.Count > 0 Then
                            dgv2.DataSource = dt
                            dgv2.Refresh()


                            For i = 0 To dgv2.Rows.Count - 1
                                If dgv2.Rows(i).Cells(5).Value <> dgv2.Rows(i).Cells(6).Value Then
                                    dgv2.Rows(i).DefaultCellStyle.BackColor = Color.MistyRose
                                End If
                            Next


                        End If


                    Catch ex As Exception
                        MsgBox(ex.ToString, MsgBoxStyle.Critical)
                    Finally
                        flagProcess = False
                    End Try
                Else
                    MsgBox("Masih ada proses yang berjalan")
                End If

            Else
                MsgBox("Sedang proses checker")
            End If
        End If
    End Sub

    Private Sub btnExportDataLebih_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnExportDataLebih.Click
        Dim export As New frmEkspor
        export.setDate = dtPick.Value
        export.setDesc = "LEBIH"
        export.ShowDialog()
    End Sub

    Private Sub btnItem_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnItem.Click
        Dim items As New frmItemDiluarStruk
        items.ShowDialog()
    End Sub

    Private Sub btnExportDataKurang_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnExportDataKurang.Click
        Dim export As New frmEkspor
        export.setDate = dtPick.Value
        export.setDesc = "KURANG"
        export.ShowDialog()
    End Sub
End Class
