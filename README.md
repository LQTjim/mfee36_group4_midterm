# mfee36_group4_midterm

---

# 資料夾說明

---

# 個人使用相關說明

請在`./parts` 下新增一個 `db-connect-local-config.php`
裡面內容大概如下:

```
<?php
$db_host='localhost'; # 有port號的範例: localhost:8889
$db_name='mfee_36_group_4';
$db_user='root';
$db_pass='root';
?>
```

目的是將資料庫的參數可以個人化。
檔名已經被 git ignore 排除 所以理論上是不影響本地端操作。

---

LQT

- [ ] 會員管理
  - [ ] 瀏覽全部會員頁面
    - [ ] 導向新增會員頁面的按鈕
    - [ ] 導向修改會員頁面的按鈕
    - [ ] 刪除會員(假刪除) -> 按了按鈕 需確認才刪除
  - [ ] 新增會員頁面
    - [ ] 驗證 input 內容
  - [ ] 修改會員頁面
    - [ ] 驗證 input 內容
  - [ ] 圖表分析
    - [ ] bar chart (ex :近三個月加入的會員數量 y :會員數 x :時間)
    - [ ] CSV 檔案上傳 批量新增會員
- [ ] 折價券管理

---