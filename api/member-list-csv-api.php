<?php
require './../parts/db-connect.php';
if (!$_POST['csvSids']) {
    exit;
}
$sql = " SELECT
m.`sid`,
m.`email`,
m.`name`,
m.`mobile`,
m.`birth`,
m.`address`,
ms.`name` AS `sex`,
ml.tier,
m.`hero_icon`,
CASE 
    mr.role 
    WHEN 'admin' THEN '管理員'    
    WHEN 'user' THEN '用戶'
    WHEN 'coach' THEN '教練'
    ELSE '未知狀態'
END AS `role`,
m.`created_at`,
m.`active`
FROM
`member` m 
LEFT JOIN `member_sex` ms ON m.sex_sid = ms.sid
LEFT JOIN `member_level` ml ON m.`member_level_sid` = ml.sid
LEFT JOIN `member_role` mr ON m.`role_sid` = mr.sid  WHERE  `m`.`sid` IN ( ";
$arr = array();
foreach ($_POST['csvSids'] as $k => $v) {
    $v = intval($v);
    if ($k == 0) {
        $sql .= ' ?';
    } else {
        $sql .= ' , ?';
    }

    $arr[] = $v;
}
$sql .= " );";
$stmt = $pdo->prepare($sql);
$stmt->execute($arr);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$columnNames = array();
$BOM = "\xEF\xBB\xBF";
if (!empty($rows)) {
    // 只需要掃描結果的第一行，以整理欄位名稱
    $firstRow = $rows[0];
    foreach ($firstRow as $colName => $val) {
        $columnNames[] = $colName;
    }
}
// 設定 CSV 下載時的檔名
$fileName = 'export.csv';
// 設定 Content-Type 和 Content-Disposition 標頭以強制下載
header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
// 打開檔案的指針
$fp = fopen('php://output', 'w');
//強制在$fp寫入BOM頭
fwrite($fp, $BOM);
// 首先將欄位名稱寫入檔案
fputcsv($fp, $columnNames);
// 然後，將其餘所有資料寫入檔案
foreach ($rows as $row) {
    fputcsv($fp, $row);
}

// 關閉檔案的指針
fclose($fp);
