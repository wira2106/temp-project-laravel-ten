Imports System.Text

Public Class FormByItem

#Region "VARIABLE"
    Private dicItem As New Dictionary(Of String, String)
#End Region

#Region "FORM FUNCITON"
    Private Sub FormByToko_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        loadPeriode()
        dtAwal.MaxDate = Today
        dtAkhir.MaxDate = Today
    End Sub

    Private Sub FormByToko_Shown(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Shown
        loadItem()
    End Sub

    Private Sub cbPLU_KeyDown(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles cbPLU.KeyDown
        If e.KeyCode = Keys.Enter Then
            cbPLU.Text = cbPLU.Text.PadLeft(7, "0")
            If dicItem.ContainsKey(cbPLU.Text) Then
                txtDeskripsi.Text = dicItem(cbPLU.Text)
            Else
                txtDeskripsi.Text = "PLU Tidak Ditemukan."
            End If
        End If
    End Sub

    Private Sub cbPLU_LostFocus(ByVal sender As Object, ByVal e As System.EventArgs) Handles cbPLU.LostFocus
        cbPLU.Text = cbPLU.Text.PadLeft(7, "0")
        If dicItem.ContainsKey(cbPLU.Text) Then
            txtDeskripsi.Text = dicItem(cbPLU.Text)
        Else
            txtDeskripsi.Text = "PLU Tidak Ditemukan."
        End If
    End Sub

    Private Sub cbToko_TextChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles cbPLU.TextChanged
        If cbPLU.Text <> String.Empty Then
            If dicItem.ContainsKey(cbPLU.Text) Then
                txtDeskripsi.Text = dicItem(cbPLU.Text)
            Else
                txtDeskripsi.Text = "PLU Tidak Ditemukan."
            End If
        End If
    End Sub

    Private Sub btnLoad_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnLoad.Click
        If dtAwal.Value > dtAkhir.Value Then
            MsgBox("Tanggal Awal Lebih Dari Tanggal Akhir.")
            Exit Sub
        End If

        If cbPLU.Text = String.Empty Then
            MsgBox("Belum Pilih PLU")
            Exit Sub
        End If

        If txtDeskripsi.Text.Contains("PLU Tidak Ditemukan") Then
            MsgBox("PLU OMI Tidak Terdaftar")
            Exit Sub
        End If

        Dim plu As String = Trim(cbPLU.Text)
        Dim tglAwal As String = dtAwal.Text
        Dim tglAkhir As String = dtAkhir.Text

        loadDataSeasonal(plu, tglAwal, tglAkhir)
    End Sub
#End Region

#Region "METHOD"
    Private Sub loadPeriode()
        sb = New StringBuilder
        sb.AppendLine("SELECT DISTINCT aso_create_dt credt,  ")
        sb.AppendLine("       TO_CHAR(aso_tglawal,'DD-MM-YYYY') awal,  ")
        sb.AppendLine("       TO_CHAR(aso_tglakhir,'DD-MM-YYYY') akhir ")
        sb.AppendLine("  FROM alokasi_seasonal_omi ")
        sb.AppendLine(" ORDER BY aso_create_dt DESC ")
        IsiDT(sb.ToString, dt, "GET PERIODE SEASONAL")

        If dt.Rows.Count > 0 Then
            dtAwal.Value = Date.ParseExact(dt.Rows(0).Item(1).ToString, "dd-MM-yyyy", System.Globalization.DateTimeFormatInfo.InvariantInfo)
            dtAkhir.Value = Date.ParseExact(dt.Rows(0).Item(2).ToString, "dd-MM-yyyy", System.Globalization.DateTimeFormatInfo.InvariantInfo)
        Else
            dtAwal.Value = Today
            dtAkhir.Value = Today
        End If
    End Sub

    Private Sub loadItem()
        sb = New StringBuilder
        sb.AppendLine("SELECT DISTINCT aso_prdcd plu, ")
        sb.AppendLine("       aso_deskripsi deskripsi ")
        sb.AppendLine("  FROM alokasi_seasonal_omi ")
        sb.AppendLine(" WHERE aso_deskripsi IS NOT NULL  ")
        sb.AppendLine(" ORDER BY aso_prdcd ")
        IsiDT(sb.ToString, dt, "GET LIST PLU")

        If dt.Rows.Count > 0 Then
            cbPLU.Items.Clear()
            dicItem = New Dictionary(Of String, String)

            For Each row As DataRow In dt.Rows
                cbPLU.Items.Add(row(0).ToString)
                dicItem.Add(row(0).ToString, row(1).ToString)
            Next
            cbPLU.Text = cbPLU.Items(0).ToString
            btnLoad.Enabled = True
        Else
            MsgBox("Belum Ada Alokasi Seasonal OMI")
            lblEmpty.Visible = True
            btnLoad.Enabled = False
        End If
    End Sub

    Private Sub loadDataSeasonal(ByVal plu As String, ByVal tglAwal As String, ByVal tglAkhir As String)
        sb = New StringBuilder
        sb.AppendLine("WITH seasonal_omi AS ( ")
        sb.AppendLine("  SELECT aso_kodetoko toko, ")
        sb.AppendLine("         tko_namaomi nama, ")
        sb.AppendLine("         SUM(aso_qtyo) alokasi, ")
        sb.AppendLine("         SUM(COALESCE(pso_qtyr, 0)) pemenuhan ")
        sb.AppendLine("    FROM alokasi_seasonal_omi ")
        sb.AppendLine("    JOIN tbmaster_tokoigr  ")
        sb.AppendLine("      ON tko_kodeomi = aso_kodetoko ")
        sb.AppendLine("    LEFT JOIN pb_seasonal_omi ")
        sb.AppendLine("      ON pso_kodeseasonal = aso_kodeseasonal ")
        sb.AppendLine("     AND pso_kodetoko = aso_kodetoko ")
        sb.AppendLine("     AND pso_prdcd = aso_prdcd ")
        sb.AppendLine("     AND COALESCE(pso_tglsph, TRUNC(SYSDATE + 1)) ")
        sb.AppendLine("         BETWEEN to_date('" & tglAwal & "','DD-MM-YYYY') ")
        sb.AppendLine("             AND to_date('" & tglAkhir & "','DD-MM-YYYY') ")
        sb.AppendLine("   WHERE aso_prdcd = '" & plu & "' ")
        sb.AppendLine("     AND aso_deskripsi IS NOT NULL  ")
        sb.AppendLine("   GROUP BY aso_kodetoko, tko_namaomi ")
        sb.AppendLine(") ")
        sb.AppendLine("SELECT toko ""OMI"",  ")
        sb.AppendLine("       nama ""Nama OMI"", ")
        sb.AppendLine("       alokasi ""QTY Alokasi"", ")
        sb.AppendLine("       pemenuhan ""QTY Pemenuhan"", ")
        sb.AppendLine("       ROUND((pemenuhan / alokasi) * 100, 2) ""% Pemenuhan"", ")
        sb.AppendLine("       (alokasi - pemenuhan) ""Sisa Alokasi"" ")
        sb.AppendLine("  FROM seasonal_omi ")
        sb.AppendLine(" ORDER BY toko ASC ")
        IsiDT(sb.ToString, dt, "GET DATA SEASONAL")

        dgvData.DataSource = dt
        styleDgvData()

        If dt.Rows.Count > 0 Then
            lblEmpty.Visible = False
        Else
            lblEmpty.Visible = True
        End If
    End Sub

    Private Sub styleDgvData()
        dgvData.ColumnHeadersDefaultCellStyle.Font = New Font("TAHOMA", 9, FontStyle.Bold, GraphicsUnit.Point)
        dgvData.ColumnHeadersDefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter
        dgvData.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCellsExceptHeaders

        For i As Integer = 0 To dgvData.Columns.Count - 1
            dgvData.Columns(i).DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter
            dgvData.Columns(i).DefaultCellStyle.Font = New Font("TAHOMA", 9, FontStyle.Regular, GraphicsUnit.Point)
            dgvData.Columns(i).ReadOnly = True
        Next

        dgvData.Columns(1).DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleLeft

        'dgvData 630
        dgvData.Columns(0).Width = 55 'OMI 55
        dgvData.Columns(1).Width = 235 'NAMA OMI 290
        dgvData.Columns(2).Width = 70 'ALOKASI 360
        dgvData.Columns(3).Width = 100 'PEMENUHAN 460
        dgvData.Columns(4).Width = 100 '% 560
        dgvData.Columns(5).Width = 70 'SISA 630
    End Sub
#End Region

End Class