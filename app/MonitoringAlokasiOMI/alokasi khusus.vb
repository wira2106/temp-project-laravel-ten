Imports System.Text
Imports System.IO
Imports System.Net.Mail
Imports System.Web
Imports Microsoft.Win32.Registry
Imports Microsoft.Win32.RegistryValueKind
Imports System.Text.RegularExpressions

Public Class FormKhusus

#Region "VARIABLE"
    Private dicToko As New Dictionary(Of String, String)
    Private oldPlu As String
#End Region

#Region "FORM FUNCTION"
    Private Sub FormKhusus_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        SplitContainerAtas.SplitterDistance = 80
        SplitContainerBawah.SplitterDistance = 510
    End Sub

    Private Sub FormKhusus_Shown(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Shown
        'GET PATH DD
        getPath()

        'GET PLU DULU
        getDataDT9()

        'GET TOKO
        getToko()

        'ATUR STYLE DGV
        styleDgvPLU()

        'LOAD DATA
        ExecScalar("SELECT count(1) FROM tbmaster_prodmast_omi", "CEK PLU OMI", count)
        If count > 0 Then
            dgvPLU.Rows.Add()
            dgvPLU.CurrentCell = dgvPLU.Item(1, dgvPLU.Rows.Count - 1)
            CType(dgvPLU, DataGridView).ClearSelection()

            dgvPLU.ReadOnly = False
            btnCreate.Enabled = True
        Else
            MsgBox("Belum Ada PLU OMI !")
            dgvPLU.ReadOnly = True
            btnCreate.Enabled = False
        End If
        Me.Cursor = Cursors.Arrow
    End Sub

    Private Sub cbToko_TextChanged(ByVal sender As Object, ByVal e As System.EventArgs) Handles cbToko.TextChanged
        If cbToko.Text.Length > 0 Then
            txtToko.Text = dicToko(cbToko.Text).ToString
        End If
    End Sub

    Private Sub dgvPLU_KeyDown(ByVal sender As Object, ByVal e As System.Windows.Forms.KeyEventArgs) Handles dgvPLU.KeyDown
        If e.KeyCode = Keys.Delete Then
            If dgvPLU.CurrentRow.Cells(0).Value IsNot Nothing Then
                dgvPLU.Rows.RemoveAt(dgvPLU.CurrentRow.Index)

                If dgvPLU.Rows.Count = 0 Then
                    dgvPLU.Rows.Add()
                End If
            End If

        ElseIf e.KeyCode = Keys.F1 Then
            fListPLU = New FormListPLU
            fListPLU.Toko = Trim(Trim(cbToko.Text))
            fListPLU.ShowDialog()

            If stringCari <> String.Empty Then
                Dim newPlu As String = stringCari

                For i As Integer = 0 To dgvPLU.Rows.Count - 1
                    If dgvPLU.Item(0, i).Value IsNot Nothing Then
                        If dgvPLU.Item(0, i).Value.ToString.Contains(newPlu) Then
                            dgvPLU.CurrentRow.Cells(0).Value = ""
                            MsgBox("PLU " & newPlu & " Sudah Diinput.")
                            Exit Sub
                        End If
                    End If
                Next

                dgvPLU.CurrentRow.Cells(0).Value = newPlu
                e.Handled = True
                dgvPLU.BeginEdit(True)
            End If
        End If
    End Sub

    Private Sub dgvPLU_CellBeginEdit(ByVal sender As Object, ByVal e As System.Windows.Forms.DataGridViewCellCancelEventArgs) Handles dgvPLU.CellBeginEdit
        If e.ColumnIndex = 0 Then 'PLU
            If dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value IsNot Nothing Then
                oldPlu = dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value
            Else
                oldPlu = String.Empty
            End If
        End If
    End Sub

    Private Sub dgvPLU_CellEndEdit(ByVal sender As Object, ByVal e As System.Windows.Forms.DataGridViewCellEventArgs) Handles dgvPLU.CellEndEdit
        If e.ColumnIndex = 0 Then 'PLU
            If dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value IsNot Nothing Then

                Dim plu As String = dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value.ToString
                plu = plu.PadLeft(7, "0")
                Dim deskripsi As String = "-"
                Dim minor As Integer = 0

                For i As Integer = 0 To e.RowIndex - 1
                    If dgvPLU.Item(0, i).Value.ToString.Contains(plu) Then
                        dgvPLU.Item(0, e.RowIndex).Value = oldPlu

                        MsgBox("PLU " & plu & " Sudah Diinput.")
                        Exit Sub
                    End If
                Next

                getDataPLU(plu, deskripsi, minor)

                If deskripsi.Contains("TAG HANOXT") Or _
                   deskripsi.Contains("DI MODIS") Or _
                   deskripsi.Contains("MINOR 0") Then
                    dgvPLU.Item(0, e.RowIndex).Value = oldPlu

                    MsgBox(deskripsi)

                Else

                    dgvPLU.Item(0, e.RowIndex).Value = plu
                    dgvPLU.Item(1, e.RowIndex).Value = deskripsi
                    dgvPLU.Item(2, e.RowIndex).Value = minor
                    dgvPLU.Item(3, e.RowIndex).Value = minor

                    If e.RowIndex = dgvPLU.Rows.Count - 1 Then
                        dgvPLU.Rows.Add()
                        dgvPLU.ClearSelection()
                        dgvPLU.CurrentCell = dgvPLU.Item(0, dgvPLU.Rows.Count - 1)
                        dgvPLU.Item(0, dgvPLU.Rows.Count - 1).Selected = True
                    End If

                End If
            End If


        ElseIf e.ColumnIndex = 3 Then 'QTY
            If dgvPLU.Item(0, e.RowIndex).Value Is Nothing Then
                dgvPLU.Item(3, e.RowIndex).Value = String.Empty
                MsgBox("Belum Input PLU")

            Else
                If dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value.ToString = "" Then
                    dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value = 0

                Else
                    Dim min As Integer = dgvPLU.Item(2, e.RowIndex).Value
                    Dim hslBagi As Integer = Math.Ceiling(dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value / min)
                    Dim sisaBagi As Integer = dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value Mod min

                    If dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value < min Then
                        dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value = min
                        MsgBox("Qty Alokasi Tidak Boleh Minimal " & min)

                    ElseIf sisaBagi <> 0 Then
                        dgvPLU.Item(e.ColumnIndex, e.RowIndex).Value = min * hslBagi
                        MsgBox("Qty Alokasi Harus Kelipatan Minor " & min)
                    End If
                End If

            End If
        End If
    End Sub

    Private Sub dgvPLU_Sorted(ByVal sender As Object, ByVal e As System.EventArgs) Handles dgvPLU.Sorted
        For i As Integer = 0 To dgvPLU.Rows.Count - 1
            If dgvPLU.Item(0, i).Value Is Nothing Then
                dgvPLU.Rows.RemoveAt(i)
                Exit For
            Else
                If dgvPLU.Item(0, i).Value = String.Empty Then
                    dgvPLU.Rows.RemoveAt(i)
                    Exit For
                End If
            End If
        Next

        dgvPLU.Rows.Add()
    End Sub

    Private Sub dgvPLU_EditingControlShowing(ByVal sender As Object, ByVal e As System.Windows.Forms.DataGridViewEditingControlShowingEventArgs) Handles dgvPLU.EditingControlShowing
        If dgvPLU.CurrentCell.ColumnIndex = 0 Or dgvPLU.CurrentCell.ColumnIndex = 3 Then
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

        Dim toko As String = Trim(cbToko.Text)
        Dim omi As String = Trim(txtToko.Text)
        omi = toko & " - " & omi

        Dim dtPB As DataTable = initPB()

        If path = String.Empty Then
            MsgBox("Path DK*.CSV Belum Diinput.")
            Exit Sub
        End If

        If toko = String.Empty Or omi = String.Empty Then
            MsgBox("Data Tidak Lengkap.")
            Exit Sub
        End If

        For Each row As DataGridViewRow In dgvPLU.Rows
            If row.Cells(0).Value Is Nothing Then
                Continue For
            Else
                If row.Cells(0).Value = String.Empty Then
                    Continue For
                Else
                    Dim plu As String = row.Cells(0).Value
                    Dim qty As Integer = row.Cells(3).Value

                    Dim pb As DataRow = dtPB.NewRow
                    pb("KODE") = toko
                    pb("PRDCD") = plu
                    pb("QTY") = qty
                    dtPB.Rows.Add(pb)
                End If
            End If
        Next

        If dtPB.Rows.Count = 0 Then
            MsgBox("Belum Ada PLU Yang Diinput.")
            Exit Sub
        End If

        If MsgBox("Yakin Kirim PB Khusus untuk Toko " & toko & " ?", MsgBoxStyle.YesNo) = MsgBoxResult.Yes Then
            btnCreate.Enabled = False
            btnTarik.Enabled = False

            Me.Cursor = Cursors.WaitCursor

            Dim filePB As String = "DK" & toko & Today.ToString("yyMMdd") & ".CSV"
            Dim noPB As String = String.Empty

            'INSERT BULK
            ExecQRY("DELETE FROM TEMP_OMI_KHUSUS ", "DELETE TEMP_OMI_KHUSUS")
            If insertBulkOra("TEMP_OMI_KHUSUS", dtPB) = False Then
                MsgBox("Error Input PLU Khusus.")
                Exit Sub
            End If

            'GET NO PB
            ExecScalar("SELECT 'K' || to_char(sysdate, 'YY') || lpad(seq_alokasi.nextval, 6, '0') FROM DUAL", "Get No PB", noPB)

            'INSERT INTO PB
            sb = New StringBuilder
            sb.AppendLine("INSERT INTO alokasi_khusus_omi ( ")
            sb.AppendLine("  AKO_KODE, ")
            sb.AppendLine("  AKO_NOPB, ")
            sb.AppendLine("  AKO_TGLPB, ")
            sb.AppendLine("  AKO_PRDCD, ")
            sb.AppendLine("  AKO_DESKRIPSI, ")
            sb.AppendLine("  AKO_MINOR, ")
            sb.AppendLine("  AKO_QTY, ")
            sb.AppendLine("  AKO_CREATE_DT ")
            sb.AppendLine(") ")
            sb.AppendLine("SELECT kode, ")
            sb.AppendLine("       '" & noPB & "', ")
            sb.AppendLine("       TRUNC(SYSDATE), ")
            sb.AppendLine("       prdcd, ")
            sb.AppendLine("       pro_singkatan, ")
            sb.AppendLine("       pro_minor, ")
            sb.AppendLine("       qty, ")
            sb.AppendLine("       sysdate ")
            sb.AppendLine("  FROM temp_omi_khusus ")
            sb.AppendLine("  JOIN tbmaster_prodmast_omi ")
            sb.AppendLine("    ON pro_kodetoko = kode ")
            sb.AppendLine("   AND pro_prdcd = prdcd ")
            ExecQRY(sb.ToString, "INSERT PB ALOKASI KHUSUS")

            'CREATE FILE CSV
            Dim dtCSV As New DataTable
            dtCSV = getDataCSV(noPB)
            If dtCSV.Rows.Count > 0 Then
                If createCsv(dtCSV, filePB, path) = False Then
                    MsgBox("Gagal Create File " & filePB & ".")
                    Exit Sub
                End If
            Else
                MsgBox("Data PB Alokasi Khusus Tidak Ditemukan.")
                Exit Sub
            End If

            If sendEmail(filePB, path, omi, noPB, dtCSV.Rows.Count) = False Then
                MsgBox("Gagal Kirim Email Ke EDP Issuing.")
                Exit Sub
            End If

            Me.Cursor = Cursors.Arrow

            MsgBox("Berhasil Kirim PB Khusus untuk Toko " & toko & " !")

            btnCreate.Enabled = True
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

    Private Sub getToko()
        sb = New StringBuilder
        sb.AppendLine("SELECT tko_kodeomi kode, ")
        sb.AppendLine("       tko_namaomi nama ")
        sb.AppendLine("  FROM tbmaster_tokoigr ")
        sb.AppendLine(" WHERE tko_kodesbu = 'O' ")
        sb.AppendLine("   AND nvl(tko_tgltutup, SYSDATE+1) > SYSDATE ")
        sb.AppendLine(" ORDER BY tko_kodeomi ASC ")
        IsiDT(sb.ToString, dt, "GET KODE SEASONAL")

        cbToko.Items.Clear()
        dicToko = New Dictionary(Of String, String)
        If dt.Rows.Count > 0 Then
            For Each row As DataRow In dt.Rows
                cbToko.Items.Add(row.Item(0).ToString)
                dicToko.Add(row.Item(0).ToString, row.Item(1).ToString)
            Next

            cbToko.Text = cbToko.Items(0).ToString

            btnCreate.Enabled = True
        Else
            MsgBox("Gagal Load Toko OMI")
            btnCreate.Enabled = False
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

        dgvPLU.Columns(1).DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleLeft

        'dgvData 450
        dgvPLU.Columns(0).Width = 80 'PLU 80
        dgvPLU.Columns(1).Width = 180 'DESKRIPSI 260
        dgvPLU.Columns(2).Width = 70 'MINOR 330
        dgvPLU.Columns(3).Width = 120 'QTY 450

        dgvPLU.Columns(0).ReadOnly = False
        dgvPLU.Columns(3).ReadOnly = False

        CType(dgvPLU.Columns(0), DataGridViewTextBoxColumn).MaxInputLength = 7
        CType(dgvPLU.Columns(3), DataGridViewTextBoxColumn).MaxInputLength = 5
    End Sub

    Private Sub getDataPLU(ByVal plu As String, ByRef deskripsi As String, ByRef minor As String)
        sb = New StringBuilder
        sb.AppendLine("SELECT pro_singkatan deskripsi, ")
        sb.AppendLine("       pro_minor minor, ")
        sb.AppendLine("       CASE WHEN coalesce(pro_tag, '-') IN ('H','A','N','O','X','T') ")
        sb.AppendLine("            THEN 0 ")
        sb.AppendLine("            ELSE 1 ")
        sb.AppendLine("       END TAG ")
        sb.AppendLine("  FROM tbmaster_prodmast_omi ")
        sb.AppendLine(" WHERE pro_kodetoko = '" & Trim(cbToko.Text) & "' ")
        sb.AppendLine("   AND pro_prdcd = '" & plu & "' ")
        IsiDT(sb.ToString, dt, "GET DATA PLU " & plu)

        If dt.Rows.Count > 0 Then
            If dt.Rows(0).Item(2) = 0 Then
                deskripsi = "PLU TAG HANOXT"
                minor = 0
            ElseIf dt.Rows(0).Item(1) = 0 Then
                deskripsi = "PLU MINOR 0"
            Else
                deskripsi = dt.Rows(0).Item(0).ToString
                minor = dt.Rows(0).Item(1)
            End If
        Else
            deskripsi = "PLU TIDAK ADA DI MODIS"
            minor = 0
        End If

    End Sub

    Private Function initPB() As DataTable
        Dim dt As New DataTable
        dt.Columns.Add("KODE")
        dt.Columns.Add("PRDCD")
        dt.Columns.Add("QTY")
        Return dt
    End Function

    Private Function getDataCSV(ByVal noPB As String) As DataTable
        sb = New StringBuilder
        sb.AppendLine("SELECT AKO_KODE TOKO, ")
        sb.AppendLine("       AKO_NOPB NOPB, ")
        sb.AppendLine("       TO_CHAR(AKO_TGLPB,'DD-MM-YYYY') TGLPB, ")
        sb.AppendLine("       AKO_PRDCD PRDCD, ")
        sb.AppendLine("       AKO_QTY QTYO ")
        sb.AppendLine("  FROM alokasi_khusus_omi ")
        sb.AppendLine(" WHERE AKO_NOPB = '" & noPB & "' ")
        sb.AppendLine("   AND TRUNC(AKO_TGLPB) = TRUNC(sysdate) ")
        sb.AppendLine(" ORDER BY AKO_PRDCD ASC ")
        IsiDT(sb.ToString, dt, "GET DATA PB ALOKASI KHUSUS")

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
                .AppendLine("<p style=""margin-top: -15px;""> Mohon dapat diproses PB Alokasi Khusus OMI untuk </p>")
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

#End Region

End Class