<script type="text/javascript">
function lanjut(id){
    document.location.href="?mod=tugtam_kreat_input&id_skp=" + id;
}
</script>
<div class="panelcontainer" style="width: 100%;">
    <h3 style="text-align: left;">DATA PERIODE PENILAIAN PEGAWAI <?php echo(strtoupper(detail_pegawai($_SESSION["simpeg_id_pegawai"], "nama_pegawai"))); ?> (NIP : <?php echo(strtoupper(detail_pegawai($_SESSION["simpeg_id_pegawai"], "nip"))); ?>)</h3>
    <div class="bodypanel">
        <table border="0px" cellspacing='0' cellpadding='0' width='100%' class="listingtable">
        <thead>
            <tr class="headertable">
                <th width='5px'>&nbsp;</th>
                <th width='40px'>No.</th>
                <th>Periode</th>
                <th width='450px'>Pejabat Penilai</th>
                <th width='450px'>Atasan Pejabat Penilai</th>
                <th width='20px'>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $res = mysql_query("SELECT
                                	a.*, b.nama_pegawai AS nama_pegawai_penilai, b.nip AS nip_penilai, 
	                                c.nama_pegawai AS nama_pegawai_atasan_penilai, c.nip AS nip_atasan_penilai,
                                    AVG(d.status_supervisi) AS spv_kreat, AVG(e.status_supervisi) AS spv_tugtam
                                FROM
                                	tbl_skp a
                                	LEFT JOIN tbl_pegawai b ON a.id_pegawai_penilai = b.id_pegawai
                                	LEFT JOIN tbl_pegawai c ON a.id_atasan_pegawai_penilai = c.id_pegawai
                                    LEFT JOIN tbl_skp_kreatifitas d ON a.id_skp = d.id_skp
                                    LEFT JOIN tbl_skp_tugas_tambahan e ON a.id_skp = e.id_skp
                                WHERE
                                	a.id_pegawai = '" . $_SESSION["simpeg_id_pegawai"] . "'
                                ORDER BY
                                	a.dari ASC
                                ");
            $no = 0;
            while($ds = mysql_fetch_array($res)){
                $status_supervisi = 0;
                if($ds["spv_kreat"] == 1 || $ds["spv_tugtam"] == 1)
                    $status_supervisi = 1;
                else if($ds["spv_kreat"] == 2 || $ds["spv_tugtam"] == 2)
                    $status_supervisi = 2;
                else if($ds["spv_kreat"] == 3 || $ds["spv_tugtam"] == 3)
                    $status_supervisi = 3;
                $no++;
                echo("<tr>");
                    echo("<td align='center'>" . status_supervisi($status_supervisi) . "</td>");
                    echo("<td align='center'>" . $no . "</td>");
                    //echo("<td align='center'>" . $ds["dari"] . "<br/>S/D<br/>" . $ds["dari"] . "</td>");
                    echo("<td align='center'>" . tglindonesia($ds["dari"]) . " S/D " . tglindonesia($ds["sampai"]) . "</td>");
                    echo("<td align='center'>" . $ds["nama_pegawai_penilai"] . " (NIP : " . $ds["nip_penilai"] . ")</td>");
                    echo("<td align='center'>" . $ds["nama_pegawai_atasan_penilai"] . " (NIP : " . $ds["nip_atasan_penilai"] . ")</td>");
                    echo("<td>
                            <img src='image/Text-Signature-32.png' width='18px' class='linkimage' title='Lanjut Untuk Mengisikan Data Hasil Penilaian Perilaku' onclick='lanjut(" . $ds["id_skp"] . ")' />
                         </td>");
                echo("</tr>");
            }
        ?>
        </tbody>
        </table>
    </div>
</div>