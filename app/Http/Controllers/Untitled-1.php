use Illuminate\Support\Facades\DB;

// Assuming you have an Oracle database connection named 'oracle'
// Make sure to configure the Oracle connection in your Laravel database.php configuration file

// With dtabOra5
if ($request->tgl_awal && $request->tgl_awal) {
    // Ambil All Periode Promo
    $query = "
        SELECT
            PRMD_PRDCD as fmkode,
            PRD_DeskripsiPanjang as desc2,
            MIN(PRMD_HrgJual) as fmjual,
            PRMD_TglAwal as fmfrtg,
            PRMD_TglAkhir as fmtotg
        FROM
            TBTR_PROMOMD
        LEFT JOIN
            TBMASTER_PRODMAST ON PRMD_PRDCD = PRD_PRDCD
        WHERE
            DATE_TRUNC('DAY', NOW()) BETWEEN DATE_TRUNC('DAY', PRMD_TglAwal) AND DATE_TRUNC('DAY', PRMD_TglAkhir)
        GROUP BY
            PRMD_PRDCD, PRD_DeskripsiPanjang, PRMD_TglAwal, PRMD_TglAkhir
        ORDER BY
            FMKODE";
} else {
    // Ambil Periode Promo Tertentu
    $query = "
        SELECT
            PRMD_PRDCD as fmkode,
            PRD_DeskripsiPanjang as desc2,
            MIN(PRMD_HrgJual) as fmjual,
            PRMD_TglAwal as fmfrtg,
            PRMD_TglAkhir as fmtotg
        FROM
            TBTR_PROMOMD
        LEFT JOIN
            TBMASTER_PRODMAST ON PRMD_PRDCD = PRD_PRDCD
        WHERE
            DATE_TRUNC('DAY', PRMD_TglAkhir) = TO_DATE('" . date('Ymd', strtotime($request->input('DTPB'))) . "', 'YYYYMMDD') AND
            DATE_TRUNC('DAY', PRMD_TglAwal) = TO_DATE('" . date('Ymd', strtotime($request->input('DTPA'))) . "', 'YYYYMMDD')" . (!empty($request->input('txtPRDCDpromo')) ? " AND PRMD_PRDCD = '" . $request->input('txtPRDCDpromo') . "'" : "") . "
        GROUP BY
            PRMD_PRDCD, PRD_DeskripsiPanjang, PRMD_TglAwal, PRMD_TglAkhir
        ORDER BY
            FMKODE";
}

// Execute the query using Laravel DB facade
$results = DB::select(DB::raw($query));

for ($p = 0; $p < count($results->rows); $p++) {
    $proses = false;

    if (empty($lastPLU)) {
        $lastPLU = substr($result->fmkode, 0, 7);
        $proses = true;
    } else {
        if (substr($lastPLU, 0, 6) != substr($result->fmkode, 0, 6) || $lastPLU == substr($result->fmkode, 0, 7)) {
            $lastPLU = substr($dtabOra5->rows[$p]["fmkode"], 0, 7);
            $proses = true;
        }
    }

    if ($proses) {

        if (count($results) == 0) {
            if (empty($dtKeluarPromo)) {
                $dtKeluarPromo = "* " . $dtabOra5->rows[$p]["fmkode"] . " - " . $dtabOra5->rows[$p]["desc2"] . " (Tidak Terdaftar Di TBTR_PROMOMD)";
            } else {
                $dtKeluarPromo .= "\n* " . $dtabOra5->rows[$p]["fmkode"] . " - " . $dtabOra5->rows[$p]["desc2"] . " (Tidak Terdaftar Di TBTR_PROMOMD)";
            }
        } else {
            $memUnit = "";
            $memPRDCD = "";
            $promoDiv = "";
            $promoDept = "";
            $promoKatb = "";

            foreach ($results as $row) {
                if (empty($memUnit) && substr($row->prdcd, -1) == "1") {
                    if (strtoupper(trim($row->ptag)) != "C" && strtoupper(trim($row->ptag)) != "X" || strtoupper(trim($row->ptag)) != "Z" && strtoupper(trim($row->ptag)) != "Q") {
                        $memUnit = $row->unit;
                        $memPRDCD = $row->prdcd;
                        $promoDiv = $row->div;
                        $promoDept = $row->dept;
                        $promoKatb = $row->katb;
                        break;
                    }
                }
            }

            foreach ($results as $row) {
                if (empty($memUnit) && substr($row->prdcd, -1) == "2") {
                    if (strtoupper(trim($row->ptag)) != "C" && strtoupper(trim($row->ptag)) != "X" || strtoupper(trim($row->ptag)) != "Z" && strtoupper(trim($row->ptag)) != "Q") {
                        $memUnit = $row->unit;
                        $memPRDCD = $row->prdcd;
                        $promoDiv = $row->div;
                        $promoDept = $row->dept;
                        $promoKatb = $row->katb;
                        break;
                    }
                }
            }

            foreach ($results as $row) {
                if (empty($memUnit) && substr($row->prdcd, -1) == "3") {
                    if (strtoupper(trim($row->ptag)) != "C" && strtoupper(trim($row->ptag)) != "X" || strtoupper(trim($row->ptag)) != "Z" && strtoupper(trim($row->ptag)) != "Q") {
                        $memUnit = $row->unit;
                        $memPRDCD = $row->prdcd;
                        $promoDiv = $row->div;
                        $promoDept = $row->dept;
                        $promoKatb = $row->katb;
                        break;
                    }
                }
            }

            foreach ($results as $row) {
                if (empty($memUnit) && substr($row->prdcd, -1) == "0") {
                    if (strtoupper(trim($row->ptag)) != "C" && strtoupper(trim($row->ptag)) != "X" || strtoupper(trim($row->ptag)) != "Z" && strtoupper(trim($row->ptag)) != "Q") {
                        $memUnit = $row->unit;
                        $memPRDCD = $row->prdcd;
                        $promoDiv = $row->div;
                        $promoDept = $row->dept;
                        $promoKatb = $row->katb;
                        break;
                    }
                }
            }

            if (empty($memUnit)) {
                if (empty($dtKeluarPromo)) {
                    $dtKeluarPromo = "* " . $dtabOra5->rows[$p]["fmkode"] . " - " . $dtabOra5->rows[$p]["desc2"] . " (Memiliki salah satu tag 'CZXQ')";
                } else {
                    $dtKeluarPromo .= "\n* " . $dtabOra5->rows[$p]["fmkode"] . " - " . $dtabOra5->rows[$p]["desc2"] . " (Memiliki salah satu tag 'CZXQ')";
                }
            } else {
                $lRec = 1;
                for ($i = 0; $i < intval($txtQtyPromo); $i++) {
                    // Assuming you have a function named 'prosesPRDCDviaDBF' for processing
                    prosesPRDCDviaDBF($dtabOra5->rows[$p]["fmkode"], $dtabOra5->rows[$p]["desc2"], 1, "manual", $promoDiv, $promoDept, $promoKatb);
                    $pRec++;
                    // You might need to implement equivalent logic for 'Application.DoEvents()'
                }
            }
        }
        $progressBarValue++;
        // You might need to implement equivalent logic for 'Application.DoEvents()'
    }
}
