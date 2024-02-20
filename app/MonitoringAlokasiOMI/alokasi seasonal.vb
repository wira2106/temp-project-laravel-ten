Imports System.Text
Imports System.IO
Imports System.Net.Mail
Imports System.Web
Imports Microsoft.Win32.Registry
Imports Microsoft.Win32.RegistryValueKind
Imports System.Text.RegularExpressions

Public Class FormAlokasi

#Region "VARIABLE"
    Private dicPeriode As New Dictionary(Of String, String)
    Private colCek As New DataGridViewCheckBoxColumn
    Private first As Boolean = True
#End Region

#Region "FORM FUNCTION"
    Private Sub FormAlokasi_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        SplitContainerAtas.SplitterDistance = 60
        SplitContainerBawah.SplitterDistance = 530
        cbKode.Items.Clear()
    End Sub

    Private Sub FormAlokasi_Shown(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Shown
        'GET PATH DD
        getPath()

        'GET PLU DULU
        getDataDT9()

        'GET SEASONAL
        getDataSeasonal()

        'LOAD DATA (KALAU ADA)
        ExecScalar("SELECT count(1) FROM alokasi_seasonal_omi", "CEK ALOKASI_SEASONAL_OMI", count)
        If count > 0 Then
            getDeskripsi()

            first = True
            loadSeasonal()

            cbKode.Enabled = True
            btnCreate.Enabled = True
        Else
            MsgBox("Belum Ada Alokasi Seasonal !")
            cbKode.Enabled = False
            btnCreate.Enabled = False
        End If
        Me.Cursor = Cursors.Arrow
    End Sub

    Private Sub cbKode_TextChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles cbKode.TextChanged
        If cbKode.Text.Length > 0 Then
            txtPeriode.Text = dicPeriode(cbKode.Text).ToString
            loadToko(cbKode.Text)
        End If
    End Sub

    Private Sub dgvToko_CellClick(ByVal sender As Object, ByVal e As System.Windows.Forms.DataGridViewCellEventArgs) Handles dgvToko.CellClick
        If e.RowIndex > -1 Then
            first = False
            loadPLU(dgvToko.Item(0, e.RowIndex).Value.ToString, cbKode.Text)
        End If
    End Sub

    Private Sub dgvToko_KeyDown(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles dgvToko.KeyDown
        If e.KeyCode = Keys.F1 Then
            If dgvToko.Rows.Count > 0 Then
                fSearch = New FormSearch
                fSearch.Text = "TOKO OMI"
                fSearch.lblSearch.Text = "Cari Toko OMI :"
                fSearch.ShowDialog()
                If stringCari <> String.Empty Then
                    For Each row As DataGridViewRow In dgvToko.Rows
                        If row.Cells("OMI").Value.ToString.Contains(stringCari) Then
                            dgvToko.ClearSelection()
                            dgvToko.FirstDisplayedScrollingRowIndex = row.Index
                            dgvToko.Rows(row.Index).Selected = True

                            loadPLU(row.Cells("OMI").Value.ToString, cbKode.Text)

                            dgvToko.Focus()
                            Exit Sub

                        ElseIf row.Cells("NAMA_OMI").Value.ToString.Contains(stringCari) Then
                            dgvToko.ClearSelection()
                            dgvToko.FirstDisplayedScrollingRowIndex = row.Index
                            dgvToko.Rows(row.Index).Selected = True

                            loadPLU(row.Cells("OMI").Value.ToString, cbKode.Text)

                            dgvToko.Focus()
                            Exit Sub
                        End If
                    Next
                End If
            End If
        End If
    End Sub

    Private Sub dgvToko_KeyUp(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles dgvToko.KeyUp
        If e.KeyCode = Keys.Up Or e.KeyCode = Keys.Down Then
            first = False
            loadPLU(dgvToko.SelectedRows(0).Cells(0).Value.ToString, cbKode.Text)
        End If
    End Sub

    Private Sub dgvPLU_DataBindingComplete(ByVal sender As Object, ByVal e As System.Windows.Forms.DataGridViewBindingCompleteEventArgs) Handles dgvPLU.DataBindingComplete
        CType(sender, DataGridView).ClearSelection()
        reColorDgvPLU()
    End Sub

    Private Sub dgvPLU_CellClick(ByVal sender As Object, ByVal e As System.Windows.Forms.DataGridViewCellEventArgs) Handles dgvPLU.CellClick
        If e.RowIndex <> -1 Then
            If e.ColumnIndex = 0 Or (e.ColumnIndex = 5 And first) Then
                If dgvPLU.Item("DESKRIPSI", e.RowIndex).Value.ToString.Contains("TAG HANOXT") Or _
                   dgvPLU.Item("DESKRIPSI", e.RowIndex).Value.ToString.Contains("DI MODIS") Then
                    dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value = False
                    dgvPLU.Item(e.ColumnIndex, e.RowIndex).ReadOnly = True

                Else
                    dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value = True
                    dgvPLU.Item(e.ColumnIndex, e.RowIndex).ReadOnly = False

                End If
            End If
        End If
    End Sub

    Private Sub dgvPLU_CellEndEdit(ByVal sender As Object, ByVal e As System.Windows.Forms.DataGridViewCellEventArgs) Handles dgvPLU.CellEndEdit
        If dgvPLU.Item("DESKRIPSI", e.RowIndex).Value.ToString.Contains("TAG HANOXT") Or _
               dgvPLU.Item("DESKRIPSI", e.RowIndex).Value.ToString.Contains("DI MODIS") Then
            dgvPLU.Item("QTY", e.RowIndex).Value = 0
        Else
            If dgvPLU.Item("QTY", e.RowIndex).Value.ToString = "" Then
                dgvPLU.Item("QTY", e.RowIndex).Value = 0
            Else
                Dim max As Integer = (dgvPLU.Item("QTY Alokasi", e.RowIndex).Value - dgvPLU.Item("QTY Pemenuhan", e.RowIndex).Value)

                If dgvPLU.Item("QTY", e.RowIndex).Value > max Then
                    dgvPLU.Item("QTY", e.RowIndex).Value = max
                    MsgBox("Qty PB Tidak Boleh Melebihi " & max)
                End If
            End If
        End If
    End Sub

    Private Sub dgvPLU_KeyDown(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles dgvPLU.KeyDown
        If e.KeyCode = Keys.F1 Then
            If dgvPLU.Rows.Count > 0 Then
                fSearch = New FormSearch
                fSearch.Text = "PLU SEASONAL"
                fSearch.lblSearch.Text = "Cari PLU/Desc :"
                fSearch.ShowDialog()

                If stringCari <> String.Empty Then
                    For Each row As DataGridViewRow In dgvPLU.Rows
                        If row.Cells("PLU").Value.ToString.Contains(stringCari) Then
                            dgvPLU.ClearSelection()
                            dgvPLU.FirstDisplayedScrollingRowIndex = row.Index
                            dgvPLU.CurrentCell = dgvPLU.Rows(row.Index).Cells("PLU")
                            dgvPLU.Rows(row.Index).Cells("PLU").Selected = True

                            dgvPLU.Focus()
                            Exit Sub

                        ElseIf row.Cells("DESKRIPSI").Value.ToString.Contains(stringCari) Then
                            dgvPLU.ClearSelection()
                            dgvPLU.FirstDisplayedScrollingRowIndex = row.Index
                            dgvPLU.CurrentCell = dgvPLU.Rows(row.Index).Cells("DESKRIPSI")
                            dgvPLU.Rows(row.Index).Cells("DESKRIPSI").Selected = True

                            dgvPLU.Focus()
                            Exit Sub
                        End If
                    Next
                End If
            End If
        End If
    End Sub

    Private Sub dgvPLU_EditingControlShowing(ByVal sender As Object, ByVal e As System.Windows.Forms.DataGridViewEditingControlShowingEventArgs) Handles dgvPLU.EditingControlShowing
        If dgvPLU.CurrentCell.ColumnIndex = 5 Or (dgvPLU.CurrentCell.ColumnIndex = 4 And first) Then
            AddHandler CType(e.Control, TextBox).KeyPress, AddressOf TextBox_keyPress
        End If
    End Sub

    Private Sub TextBox_keyPress(ByVal sender As Object, ByVal e As KeyPressEventArgs)
        If Asc(e.KeyChar) <> 13 AndAlso Asc(e.KeyChar) <> 8 AndAlso Not IsNumeric(e.KeyChar) Then e.Handled = True
    End Sub

    Private Sub btnTarik_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnTarik.Click
        If MsgBox("Tarik Ulang Data DT9 ?", MsgBoxStyle.YesNo) = MsgBoxResult.Yes Then
            fTarikData = New FormTarikData
            fTarikData.ShowDialog()

            getDeskripsi()
        End If
    End Sub

    Private Sub btnSearch_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnSearch.Click
        FBD.ShowDialog()
        txtPath.Text = FBD.SelectedPath
        If txtPath.Text <> "" Then
            CurrentUser.OpenSubKey(RegPath & ProgName, True).SetValue("PATH FILE PBSL", txtPath.Text)
        End If
    End Sub

    Private Sub btnCreate_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnCreate.Click
        Dim path As String = Trim(txtPath.Text)

        Dim kdSeasonal As String = Trim(cbKode.Text)
        Dim periode As String() = Strings.Split(Trim(txtPeriode.Text), " ")
        Dim tglAwal As String = periode(0).ToString
        Dim tglAkhir As String = periode(2).ToString

        Dim toko As String = dgvToko.SelectedRows(0).Cells("OMI").Value.ToString
        Dim omi As String = dgvToko.SelectedRows(0).Cells("NAMA_OMI").Value.ToString
        omi = toko & " - " & omi
        Dim tmpJT As String = dgvToko.SelectedRows(0).Cells("JATUH_TEMPO").Value.ToString
        Dim tglJT As Date = Date.ParseExact(tmpJT, "dd-MM-yyyy", System.Globalization.DateTimeFormatInfo.InvariantInfo)

        Dim dtPB As DataTable = initPB()

        If path = String.Empty Then
            MsgBox("Path DS*.CSV Belum Diinput.")
            Exit Sub
        End If

        If toko = String.Empty Or dgvPLU.Rows.Count = 0 Then
            MsgBox("Data Tidak Lengkap.")
            Exit Sub
        End If

        If Integer.Parse(Today.ToString("yyyyMMdd")) > Integer.Parse(tglJT.ToString("yyyyMMdd")) Then
            MsgBox("Sudah Lewat Tanggal Jatuh Tempo.")
            Exit Sub
        End If

        For Each row As DataGridViewRow In dgvPLU.Rows
            If row.Cells("colCekBox").Value Is DBNull.Value Then
                row.Cells("colCekBox").Value = False
            End If

            If CType(row.Cells("colCekBox").Value, Boolean) = True And _
               row.Cells("QTY").Value > 0 Then

                Dim plu As String = row.Cells("PLU").Value
                Dim qty As Integer = row.Cells("QTY").Value

                Dim pb As DataRow = dtPB.NewRow
                pb("KODESEASONAL") = kdSeasonal
                pb("TGLAWAL") = tglAwal
                pb("TGLAKHIR") = tglAkhir
                pb("KODETOKO") = toko
                pb("TGLJT") = tmpJT
                pb("PRDCD") = plu
                pb("QTYO") = qty

                dtPB.Rows.Add(pb)
            End If
        Next

        If dtPB.Rows.Count = 0 Then
            MsgBox("Tidak Ada PLU Yang Dipilih.")
            Exit Sub
        End If

        If MsgBox("Yakin Kirim PB Seasonal untuk Toko " & toko & " ?", MsgBoxStyle.YesNo) = MsgBoxResult.Yes Then
            btnCreate.Enabled = False
            btnTarik.Enabled = False

            Me.Cursor = Cursors.WaitCursor

            Dim filePB As String = "DS" & toko & Today.ToString("yyMMdd") & ".CSV"
            Dim noPB As String = String.Empty

            'INSERT BULK
            ExecQRY("DELETE FROM TEMP_OMI_PB ", "DELETE TEMP_OMI_PB")
            If insertBulkOra("TEMP_OMI_PB", dtPB) = False Then
                MsgBox("Error Input PLU Seasonal.")
                Exit Sub
            End If

            'GET NO PB
            ExecScalar("SELECT 'S' || to_char(sysdate, 'YY') || lpad(seq_alokasi.nextval, 6, '0') FROM DUAL", "Get No PB", noPB)

            'INSERT INTO PB
            sb = New StringBuilder
            sb.AppendLine("INSERT INTO pb_seasonal_omi ( ")
            sb.AppendLine("  PSO_KODESEASONAL, ")
            sb.AppendLine("  PSO_TGLAWAL, ")
            sb.AppendLine("  PSO_TGLAKHIR, ")
            sb.AppendLine("  PSO_KODETOKO, ")
            sb.AppendLine("  PSO_NOPB, ")
            sb.AppendLine("  PSO_TGLPB, ")
            sb.AppendLine("  PSO_TGLJT, ")
            sb.AppendLine("  PSO_PRDCD, ")
            sb.AppendLine("  PSO_DESKRIPSI, ")
            sb.AppendLine("  PSO_QTYO, ")
            sb.AppendLine("  PSO_CREATE_DT ")
            sb.AppendLine(") ")
            sb.AppendLine("SELECT kodeseasonal, ")
            sb.AppendLine("       to_date(tglawal, 'DD-MM-YYYY'), ")
            sb.AppendLine("       to_date(tglakhir, 'DD-MM-YYYY'), ")
            sb.AppendLine("       kodetoko, ")
            sb.AppendLine("       '" & noPB & "', ")
            sb.AppendLine("       TRUNC(SYSDATE), ")
            sb.AppendLine("       to_date(tgljt, 'DD-MM-YYYY'), ")
            sb.AppendLine("       prdcd, ")
            sb.AppendLine("       pro_singkatan, ")
            sb.AppendLine("       qtyo, ")
            sb.AppendLine("       sysdate ")
            sb.AppendLine("  FROM temp_omi_pb ")
            sb.AppendLine("  JOIN tbmaster_prodmast_omi ")
            sb.AppendLine("    ON pro_kodetoko = kodetoko ")
            sb.AppendLine("   AND pro_prdcd = prdcd ")
            ExecQRY(sb.ToString, "INSERT PB ALOKASI SEASONAL")

            'CREATE FILE CSV
            Dim dtCSV As New DataTable
            dtCSV = getDataCSV(noPB)
            If dtCSV.Rows.Count > 0 Then
                If createCsv(dtCSV, filePB, path) = False Then
                    MsgBox("Gagal Create File " & filePB & ".")
                    Exit Sub
                End If
            Else
                MsgBox("Data PB Alokasi Seasonal Tidak Ditemukan.")
                Exit Sub
            End If

            If sendEmail(filePB, path, omi, noPB, dtCSV.Rows.Count) = False Then
                MsgBox("Gagal Kirim Email Ke EDP Issuing.")
            End If

            Me.Cursor = Cursors.Arrow

            MsgBox("Berhasil Kirim PB Seasonal untuk Toko " & toko & " !")

            btnCreate.Enabled = False
            btnTarik.Enabled = True
        End If
    End Sub
#End Region

#Region "METHOD"
    Private Sub getPath()
        If CurrentUser.OpenSubKey(RegPath & ProgName, False) Is Nothing Then
            CurrentUser.CreateSubKey(RegPath & ProgName, Microsoft.Win32.RegistryKeyPermissionCheck.ReadWriteSubTree)
        End If

        If CurrentUser.OpenSubKey(RegPath & ProgName, True).GetValue("PATH FILE PBSL", "") = "" Then
            CurrentUser.OpenSubKey(RegPath & ProgName, True).SetValue("PATH FILE PBSL", "")
        Else
            txtPath.Text = CurrentUser.OpenSubKey(RegPath & ProgName, True).GetValue("PATH FILE PBSL", "")
        End If
    End Sub

    Private Sub getDataDT9()
        ExecScalar("SELECT count(1) FROM tbmaster_prodmast_omi WHERE TRUNC(pro_create_dt) = TRUNC(sysdate)", "GET NOW!", count)

        If count = 0 Then
            fTarikData = New FormTarikData
            fTarikData.ShowDialog()
        End If
    End Sub

    Private Sub getDataSeasonal()
        Dim fileSeasonal As String = "OMI" & Today.ToString("yyyy") & kdIGR.ToString & ".CSV"
        Dim dtSeasonal As New DataTable

        dtSeasonal.Columns.Add("kodeseasonal")
        dtSeasonal.Columns.Add("tglawal")
        dtSeasonal.Columns.Add("tglakhir")
        dtSeasonal.Columns.Add("kodetoko")
        dtSeasonal.Columns.Add("tgljt")
        dtSeasonal.Columns.Add("prdcd")
        dtSeasonal.Columns.Add("qty")

        'DOWNLOAD DULU CSV DARI FTP
        If downloadFTP(pathLocal, fileSeasonal, "SEASONAL", 19) = False Then
            Exit Sub
        End If

        'READ CSV
        Dim fullPath As String = pathLocal & "\" & fileSeasonal
        Try
            readCSV(fullPath, dtSeasonal)
        Catch ex As Exception
            MsgBox("File " & fileSeasonal & " Gagal Dibaca")
            Exit Sub
        End Try

        'CEK CEK AGAIN
        If dtSeasonal.Rows.Count > 0 Then
            ExecQRY("DELETE FROM temp_alokasi_seasonal_omi ", "DELETE TEMP_ALOKASI_SEASONAL_OMI")
            If insertBulkOra("temp_alokasi_seasonal_omi", dtSeasonal) = False Then
                MsgBox("File " & fileSeasonal & " Tidak Dapat Disimpan")
            End If

            'INSERT DATA ITEM KE ALOKASI SEASONAL
            sb = New StringBuilder
            sb.AppendLine("MERGE INTO alokasi_seasonal_omi t ")
            sb.AppendLine("USING temp_alokasi_seasonal_omi s ")
            sb.AppendLine("   ON ( ")
            sb.AppendLine("           t.aso_kodeseasonal = s.kodeseasonal ")
            sb.AppendLine("       AND t.aso_kodetoko = s.kodetoko ")
            sb.AppendLine("       AND t.aso_prdcd = s.prdcd ")
            sb.AppendLine("      ) ")
            sb.AppendLine("WHEN MATCHED THEN ")
            sb.AppendLine("  UPDATE SET t.aso_tglawal = TO_DATE(s.tglawal, 'DD-MM-YYYY'), ")
            sb.AppendLine("             t.aso_tglakhir = TO_DATE(s.tglakhir, 'DD-MM-YYYY'), ")
            'sb.AppendLine("             t.aso_tgljt = TO_DATE(s.tgljt, 'DD-MM-YYYY'), ")
            sb.AppendLine("             t.aso_qtyo = s.qty, ")
            sb.AppendLine("             t.aso_create_dt = SYSDATE ")
            sb.AppendLine("WHEN NOT MATCHED THEN ")
            sb.AppendLine("  INSERT ( ")
            sb.AppendLine("    t.aso_kodeseasonal, ")
            sb.AppendLine("    t.aso_tglawal, ")
            sb.AppendLine("    t.aso_tglakhir, ")
            sb.AppendLine("    t.aso_kodetoko, ")
            sb.AppendLine("    t.aso_tgljt, ")
            sb.AppendLine("    t.aso_prdcd, ")
            sb.AppendLine("    t.aso_qtyo, ")
            sb.AppendLine("    t.aso_create_dt ")
            sb.AppendLine("  ) VALUES ( ")
            sb.AppendLine("    s.kodeseasonal, ")
            sb.AppendLine("    TO_DATE(s.tglawal, 'DD-MM-YYYY'), ")
            sb.AppendLine("    TO_DATE(s.tglakhir, 'DD-MM-YYYY'), ")
            sb.AppendLine("    s.kodetoko, ")
            sb.AppendLine("    TO_DATE(s.tgljt, 'DD-MM-YYYY'), ")
            sb.AppendLine("    s.prdcd, ")
            sb.AppendLine("    s.qty, ")
            sb.AppendLine("    SYSDATE ")
            sb.AppendLine("  ) ")
            ExecQRY(sb.ToString, "INSERT ALOKASI_SEASONAL_OMI")

            'UPDATE JATUH TEMPO
            sb = New StringBuilder
            sb.AppendLine("MERGE INTO alokasi_seasonal_omi t  ")
            sb.AppendLine("USING ( ")
            sb.AppendLine("  SELECT kodeseasonal, kodetoko, tgljt, count(1)  ")
            sb.AppendLine("  FROM temp_alokasi_seasonal_omi  ")
            sb.AppendLine("  GROUP BY kodeseasonal, kodetoko, tgljt ")
            sb.AppendLine(") s  ")
            sb.AppendLine("ON (  ")
            sb.AppendLine("    t.aso_kodeseasonal = s.kodeseasonal  ")
            sb.AppendLine("AND t.aso_kodetoko = s.kodetoko  ")
            sb.AppendLine(")  ")
            sb.AppendLine("WHEN MATCHED THEN  ")
            sb.AppendLine("  UPDATE SET t.aso_tgljt = TO_DATE(s.tgljt, 'DD-MM-YYYY') ")
            ExecQRY(sb.ToString, "UPDATE TGL JATUH TEMPO")
        Else
            MsgBox("File " & fileSeasonal & " Gagal Dibaca")
        End If
    End Sub

    Private Sub readCSV(ByVal fileCSV As String, ByRef dtCSV As DataTable)
        Dim myReader As New StreamReader(fileCSV)
        Dim ColumnNames, fieldValues As String()

        'Open file and read first two lines
        ColumnNames = myReader.ReadLine().Split("|")

        While myReader.Peek() <> -1
            fieldValues = myReader.ReadLine().Split("|")
            If fieldValues.Length > 0 Then
                Dim row As DataRow = dtCSV.NewRow

                row("kodeseasonal") = fieldValues(0).ToString
                row("tglawal") = fieldValues(1).ToString
                row("tglakhir") = fieldValues(2).ToString
                row("kodetoko") = fieldValues(3).ToString
                row("tgljt") = fieldValues(4).ToString
                row("prdcd") = fieldValues(5).ToString
                row("qty") = fieldValues(6)

                dtCSV.Rows.Add(row)
            End If
        End While

        myReader.Close()
    End Sub

    Private Sub getDeskripsi()
        sb = New StringBuilder
        sb.AppendLine("SELECT count(1) FROM alokasi_seasonal_omi ")
        sb.AppendLine(" WHERE aso_deskripsi IS NULL ")
        sb.AppendLine("    OR TRUNC(COALESCE(aso_modify_dt, sysdate - 1)) < TRUNC(sysdate) ")

        ExecScalar(sb.ToString.ToString, "CEK DESKRIPSI", count)

        If count > 0 Then
            sb = New StringBuilder
            sb.AppendLine("MERGE INTO alokasi_seasonal_omi t ")
            sb.AppendLine("USING tbmaster_prodmast_omi s ")
            sb.AppendLine("   ON ( ")
            sb.AppendLine("           t.aso_kodetoko = s.pro_kodetoko ")
            sb.AppendLine("       AND t.aso_prdcd = s.pro_prdcd ")
            sb.AppendLine("      ) ")
            sb.AppendLine("WHEN MATCHED THEN ")
            sb.AppendLine("  UPDATE SET t.aso_deskripsi = s.pro_singkatan, ")
            sb.AppendLine("             t.aso_modify_dt = SYSDATE ")

            ExecQRY(sb.ToString, "UPDATE DESKRIPSI")
        End If
    End Sub

    Private Sub loadSeasonal()
        sb = New StringBuilder
        sb.AppendLine("SELECT DISTINCT aso_kodeseasonal kode,  ")
        sb.AppendLine("       to_char(aso_tglawal, 'DD-MM-YYYY') ||  ")
        sb.AppendLine("       ' s/d ' || ")
        sb.AppendLine("       to_char(aso_tglakhir, 'DD-MM-YYYY') periode ")
        sb.AppendLine("  FROM alokasi_seasonal_omi ")
        IsiDT(sb.ToString, dt, "GET KODE SEASONAL")

        cbKode.Items.Clear()
        dicPeriode = New Dictionary(Of String, String)
        If dt.Rows.Count > 0 Then
            For Each row As DataRow In dt.Rows
                cbKode.Items.Add(row.Item(0).ToString)
                dicPeriode.Add(row.Item(0).ToString, row.Item(1).ToString)
            Next

            cbKode.Text = cbKode.Items(0).ToString

            cbKode.Enabled = True
            btnCreate.Enabled = True
        Else
            cbKode.Enabled = False
            btnCreate.Enabled = False
        End If
    End Sub

    Private Sub loadToko(ByVal kdSeasonal As String)
        sb = New StringBuilder
        sb.AppendLine("SELECT DISTINCT aso_kodetoko OMI, ")
        sb.AppendLine("       tko_namaomi NAMA_OMI, ")
        sb.AppendLine("       TO_CHAR(aso_tgljt,'DD-MM-YYYY') JATUH_TEMPO ")
        sb.AppendLine("  FROM alokasi_seasonal_omi ")
        sb.AppendLine("  JOIN tbmaster_tokoigr ")
        sb.AppendLine("    ON aso_kodetoko = tko_kodeomi  ")
        sb.AppendLine(" WHERE aso_kodeseasonal = '" & kdSeasonal & "' ")
        sb.AppendLine(" ORDER BY aso_kodetoko ASC ")
        IsiDT(sb.ToString, dt, "GET TOKO")

        dgvToko.DataSource = dt
        styleDgvToko()

        If dt.Rows.Count > 0 Then
            lblEmptyToko.Visible = False
            lblEmptyPLU.Visible = False
            btnCreate.Enabled = True

            loadPLU(dgvToko.CurrentRow.Cells(0).Value.ToString, cbKode.Text.ToString)
        Else
            lblEmptyToko.Visible = True
            lblEmptyPLU.Visible = True
            btnCreate.Enabled = False
        End If
    End Sub

    Private Sub styleDgvToko()
        dgvToko.ColumnHeadersDefaultCellStyle.Font = New Font("TAHOMA", 9, FontStyle.Bold, GraphicsUnit.Point)
        dgvToko.ColumnHeadersDefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter

        For i As Integer = 0 To dgvToko.Columns.Count - 1
            dgvToko.Columns(i).DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter
            dgvToko.Columns(i).DefaultCellStyle.Font = New Font("TAHOMA", 9, FontStyle.Regular, GraphicsUnit.Point)
            dgvToko.Columns(i).ReadOnly = True
        Next

        dgvToko.Columns(1).DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleLeft

        'dgvToko 380
        dgvToko.Columns(0).Width = 50 'OMI 50
        dgvToko.Columns(1).Width = 225 'NAMA_OMI 275
        dgvToko.Columns(2).Width = 105 'JATUH_TEMPO 380
    End Sub

    Private Sub loadPLU(ByVal toko As String, ByVal kdSeasonal As String)
        sb = New StringBuilder
        sb.AppendLine("SELECT ")
        sb.AppendLine("       aso_prdcd plu, ")
        sb.AppendLine("       CASE WHEN pro_tag IN ('H','A','N','O','X','T')  ")
        sb.AppendLine("            THEN 'PLU TAG HANOXT'  ")
        sb.AppendLine("            ELSE  COALESCE(aso_deskripsi, 'PLU TIDAK ADA DI MODIS')  ")
        sb.AppendLine("       END deskripsi, ")
        sb.AppendLine("       aso_qtyo ""QTY Alokasi"", ")
        sb.AppendLine("       COALESCE(aso_qtyr, 0) ""QTY Pemenuhan"", ")
        sb.AppendLine("       (aso_qtyo - COALESCE(aso_qtyr, 0)) QTY, ")
        sb.AppendLine("       CASE WHEN pro_tag IN ('H','A','N','O','X','T') OR aso_deskripsi IS NULL ")
        sb.AppendLine("            THEN 0 ")
        sb.AppendLine("            ELSE 1 ")
        sb.AppendLine("       END OK ")
        sb.AppendLine("  FROM alokasi_seasonal_omi ")
        sb.AppendLine("  LEFT JOIN tbmaster_prodmast_omi ")
        sb.AppendLine("    ON pro_prdcd = aso_prdcd ")
        sb.AppendLine("   AND pro_kodetoko = aso_kodetoko ")
        sb.AppendLine(" WHERE aso_kodeseasonal = '" & kdSeasonal & "' ")
        sb.AppendLine("   AND aso_kodetoko = '" & toko & "' ")
        sb.AppendLine("   AND aso_qtyo > COALESCE(aso_qtyr, 0) ")
        sb.AppendLine(" ORDER BY aso_prdcd ASC ")
        IsiDT(sb.ToString, dt, "GET PLU")

        dgvPLU.Columns.Clear()
        dgvPLU.DataSource = dt
        insertColCek()
        styleDgvPLU()

        If dt.Rows.Count > 0 Then

            If masihAdaPB(toko, kdSeasonal) Then
                MsgBox("PB Seasonal " & toko & " Belum Proses SPH.")
                btnCreate.Enabled = False
            Else
                btnCreate.Enabled = True
            End If

        Else
            btnCreate.Enabled = False
        End If
    End Sub

    Private Sub insertColCek()
        If cbKode.Items.Count > 0 Then
            'INSERT CHECK BOX
            colCek = New DataGridViewCheckBoxColumn
            colCek.Name = "colCekBox"
            colCek.HeaderText = ""
            colCek.DataPropertyName = "OK"
            dgvPLU.Columns.Insert(0, colCek)
        End If
    End Sub

    Private Sub styleDgvPLU()
        dgvPLU.ColumnHeadersDefaultCellStyle.Font = New Font("TAHOMA", 9, FontStyle.Bold, GraphicsUnit.Point)
        dgvPLU.ColumnHeadersDefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter
        dgvPLU.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.DisplayedCellsExceptHeaders

        For i As Integer = 0 To dgvPLU.Columns.Count - 1
            dgvPLU.Columns(i).DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter
            dgvPLU.Columns(i).DefaultCellStyle.Font = New Font("TAHOMA", 9, FontStyle.Regular, GraphicsUnit.Point)
            dgvPLU.Columns(i).ReadOnly = True
        Next

        dgvPLU.Columns(2).DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleLeft

        'dgvData 510
        dgvPLU.Columns(0).Width = 30 'CHECKBOX 25
        dgvPLU.Columns(1).Width = 75 'PLU 75
        dgvPLU.Columns(2).Width = 180 'DESKRIPSI 255
        dgvPLU.Columns(3).Width = 70 'QTY_ALOKASI 325
        dgvPLU.Columns(4).Width = 95 'QTY_PEMENUHAN 420
        dgvPLU.Columns(5).Width = 60 'QTY_PB 480
        dgvPLU.Columns(6).Visible = False

        dgvPLU.Columns(0).ReadOnly = False
        dgvPLU.Columns(5).ReadOnly = False

        CType(dgvPLU.Columns("QTY"), DataGridViewTextBoxColumn).MaxInputLength = 5

        For Each row As DataGridViewRow In dgvPLU.Rows
            If Not row.Cells("DESKRIPSI").Value.ToString.Contains("PLU") Then
                row.Cells(0).Value = 1
            Else
                row.Cells(0).Value = 0
                row.Cells(5).Value = 0
            End If
        Next
        dgvPLU.Refresh()
    End Sub

    Private Sub reColorDgvPLU()
        'MEWARNAI
        For i As Integer = 0 To dgvPLU.Rows.Count - 1
            If dgvPLU.Item("DESKRIPSI", i).Value.ToString.Contains("TAG HANOXT") Or _
               dgvPLU.Item("DESKRIPSI", i).Value.ToString.Contains("DI MODIS") Then
                dgvPLU.Rows(i).DefaultCellStyle.BackColor = Color.PaleVioletRed
                dgvPLU.Rows(i).DefaultCellStyle.ForeColor = Color.Black
            Else
                dgvPLU.Rows(i).DefaultCellStyle.BackColor = Color.White
                dgvPLU.Rows(i).DefaultCellStyle.ForeColor = Color.Black
            End If
        Next
    End Sub

    Private Function initPB() As DataTable
        Dim dt As New DataTable
        dt.Columns.Add("KODESEASONAL")
        dt.Columns.Add("TGLAWAL")
        dt.Columns.Add("TGLAKHIR")
        dt.Columns.Add("KODETOKO")
        dt.Columns.Add("TGLJT")
        dt.Columns.Add("PRDCD")
        dt.Columns.Add("QTYO")
        Return dt
    End Function

    Private Function getDataCSV(ByVal noPB As String) As DataTable
        sb = New StringBuilder
        sb.AppendLine("SELECT pso_kodetoko TOKO, ")
        sb.AppendLine("       pso_nopb NOPB, ")
        sb.AppendLine("       TO_CHAR(pso_tglpb,'DD-MM-YYYY') TGLPB, ")
        sb.AppendLine("       pso_prdcd PRDCD, ")
        sb.AppendLine("       pso_qtyo QTYO ")
        sb.AppendLine("  FROM pb_seasonal_omi ")
        sb.AppendLine(" WHERE pso_nopb = '" & noPB & "' ")
        sb.AppendLine("   AND TRUNC(pso_tglpb) = TRUNC(sysdate) ")
        sb.AppendLine(" ORDER BY pso_prdcd ASC ")
        IsiDT(sb.ToString, dt, "GET DATA PB ALOKASI SEASONAL")

        Return dt
    End Function

    Private Function createCsv(ByVal data As DataTable, ByVal filePB As String, ByVal path As String) As Boolean
        Dim pathFile As String = path & "\" & filePB

        Try
            If File.Exists(pathFile) Then
                File.Delete(pathFile)
            End If

            Dim TextFile As New StreamWriter(pathFile, False)

            'write column header table
            Dim str As String
            str = ""
            For j As Integer = 0 To data.Columns.Count - 1
                str &= data.Columns(j).ColumnName.ToString & "|"
            Next
            str = Strings.Left(str, str.Length - 1)
            TextFile.WriteLine(str)

            For j As Integer = 0 To data.Rows.Count - 1
                str = ""
                For k As Integer = 0 To data.Columns.Count - 1
                    str &= data.Rows(j).Item(k).ToString & "|"
                Next
                str = Strings.Left(str, str.Length - 1)
                TextFile.WriteLine(str)
            Next

            TextFile.Close()

            Return True
        Catch ex As Exception
            Return False
        End Try
    End Function

    Private Sub getEmail()
        sb = New StringBuilder
        sb.AppendLine("SELECT mec_mail_server,  ")
        sb.AppendLine("       mec_mail_port, ")
        sb.AppendLine("       mec_mail_user, ")
        sb.AppendLine("       mec_mail_pass, ")
        sb.AppendLine("       mec_to, ")
        sb.AppendLine("       coalesce(mec_cc,'-'), ")
        sb.AppendLine("       mec_subject ")
        sb.AppendLine("  FROM MASTER_EMAIL_CABANG ")

        IsiDT(sb.ToString, dt, "GET EMAIL")

        If dt.Rows.Count > 0 Then
            smtpServer = dt.Rows(0).Item(0).ToString
            iPort = dt.Rows(0).Item(1).ToString
            ifrom = dt.Rows(0).Item(2).ToString
            iPassword = Decrypt(dt.Rows(0).Item(3).ToString, "M0nit0ring0mi")
            iTo = dt.Rows(0).Item(4).ToString
            iTo = New Regex("\s+").Replace(iTo, String.Empty)
            iCc = dt.Rows(0).Item(5).ToString
            iSubject = dt.Rows(0).Item(6).ToString
        End If
    End Sub

    Private Function sendEmail(ByVal filePB As String, ByVal path As String, _
                               ByVal toko As String, _
                               ByVal nopb As String, _
                               ByVal jmlitem As String) As Boolean
        getEmail()

        Try
            Dim mMessage As New MailMessage()

            Dim eServer As String = smtpServer
            Dim ePort As String = iPort
            Dim eUser As String = iFrom
            Dim ePassword As String = iPassword
            Dim eTo As String = iTo
            Dim eCc As String = iCc

            mMessage.From = New MailAddress(eUser)
            mMessage.To.Add(eTo)
            If Not (eCc <> "-" Or eCc <> "") Then
                mMessage.CC.Add(eCc)
            End If

            mMessage.Subject = iSubject

            Dim body As New StringBuilder
            Dim tmpIGR As String() = Strings.Split(namaIGR, " ")
            With body
                .AppendLine("<h4> To : EDP Issuing " & Capitalize(tmpIGR(1)).ToString & " </h4>")
                .AppendLine("<p> Dh, </p>")
                .AppendLine("<p style=""margin-top: -15px;""> Mohon dapat diproses PB Alokasi Seasonal OMI untuk </p>")
                .AppendLine("<p style=""margin-top: -10px;margin-left: 30px""> Toko OMI : <b>" & toko & "</b>, </p>")
                .AppendLine("<p style=""margin-top: -20px;margin-left: 30px""> No PB : <b>" & nopb & "</b>, </p>")
                .AppendLine("<p style=""margin-top: -20px;margin-left: 30px""> Tgl PB : <b>" & Today.ToString("dd-MM-yyyy") & "</b>, </p>")
                .AppendLine("<p style=""margin-top: -20px;margin-left: 30px""> Jml Item : <b>" & jmlitem & "</b> </p>")
                .AppendLine("<p style=""margin-top: -5px;""> Demikian informasi dari kami.</p> ")
                .AppendLine("<p style=""margin-top: -20px;""> Terimakasih. </p>")

                .AppendLine("<h4 style=""margin-top: 35px;""> EDP OMI </h4>")
            End With

            mMessage.Body = body.ToString
            mMessage.IsBodyHtml = True
            mMessage.Attachments.Clear()
            If File.Exists(path & "\" & filePB) Then
                Dim attach As Attachment = New Attachment(path & "\" & filePB)
                mMessage.Attachments.Add(attach)
            End If

            Dim smtp As New SmtpClient
            smtp.Credentials = New Net.NetworkCredential(eUser, ePassword)
            smtp.Host = eServer
            smtp.Port = ePort
            smtp.DeliveryMethod = SmtpDeliveryMethod.Network

            Try
                smtp.Send(mMessage)
            Catch ex As Exception
                Return False
            End Try
            Return True
        Catch ex As Exception
            Return False
        End Try
    End Function

    Private Function masihAdaPB(ByVal toko As String, ByVal kdSeasonal As String) As Boolean
        sb = New StringBuilder
        sb.AppendLine("SELECT COUNT(1) ")
        sb.AppendLine("  FROM pb_seasonal_omi  ")
        sb.AppendLine(" WHERE pso_kodeseasonal = '" & kdSeasonal & "' ")
        sb.AppendLine("   AND pso_kodetoko = '" & toko & "' ")
        sb.AppendLine("   AND pso_qtyr IS NULL ")
        ExecScalar(sb.ToString, "CEK MASIH ADA PB", count)

        If count > 0 Then
            Return True
        Else
            Return False
        End If
    End Function
#End Region

End Class