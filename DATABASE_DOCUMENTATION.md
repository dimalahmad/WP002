# Database Documentation: WP001
Generated on: 2026-01-21 04:03:19

## Table: `CONTRACT`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| ROWID | numeric | - | NO |
| CONTRACTNO | char | 15 | NO |
| ADDENDUMNO | numeric | - | NO |
| TRANSTYPE | char | 4 | NO |
| CONTRACT_TYPE | varchar | 20 | YES |
| CONTRACT_DATE | datetime | - | YES |
| CUSTCODE | char | 8 | YES |
| CUSTOMER_NAME | varchar | 50 | YES |
| ENDUSER_NAME | varchar | 50 | YES |
| DP | numeric | - | YES |
| TERMPAYMENT | varchar | 100 | YES |
| TERMDELIVER | varchar | 100 | YES |
| CURRENCY | char | 15 | YES |
| BEG_DATE | datetime | - | YES |
| END_DATE | datetime | - | YES |
| HPP_AVARAGE | decimal | - | YES |
| MARGIN_AVARAGE | decimal | - | YES |
| FILE_NAME | text | 2147483647 | YES |
| STATUS | char | 2 | YES |
| PROD_GROUP | char | 5 | YES |
| PRODID | char | 5 | YES |
| PRODUCT_NAME | varchar | 100 | YES |
| PIECES | decimal | - | YES |
| WEIGHT | decimal | - | YES |
| PRICE | decimal | - | YES |
| HPP | decimal | - | YES |
| MARGIN | decimal | - | YES |
| TOTAL_PRICE | decimal | - | YES |
| TOTAL_MARGIN | decimal | - | YES |
| FLAG_UPDATE | char | 1 | YES |

### Sample Data (First 3 rows)
| ROWID | CONTRACTNO | ADDENDUMNO | TRANSTYPE | CONTRACT_TYPE | CONTRACT_DATE | CUSTCODE | CUSTOMER_NAME | ENDUSER_NAME | DP | TERMPAYMENT | TERMDELIVER | CURRENCY | BEG_DATE | END_DATE | HPP_AVARAGE | MARGIN_AVARAGE | FILE_NAME | STATUS | PROD_GROUP | PRODID | PRODUCT_NAME | PIECES | WEIGHT | PRICE | HPP | MARGIN | TOTAL_PRICE | TOTAL_MARGIN | FLAG_UPDATE |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | P-240500238000 | 0 | SD02 | SALES REGULAR | 2024-05-06 00:00:00.000 | K0146 | PT KRAKATAU WAJATAMA OSAKA STEEL MARKETING | INDO SADANG FABRIKATOR, PT | 0 | CASH BEFORE DELIVERY | LOCO GUDANG PT. KBK DIATAS TRUK | IDR | 2024-05-06 00:00:00.000 | 2024-06-30 00:00:00.000 | 11200.00 | 3680.00 | INDO SADANG FABRICATOR_ISFA-PO 2024 05 1460.pdf | R2 | 0 | L0214 | L-Angle 13 | 12 | 3369.60 | 14880.00 | 11200.00 | 3680.00 | 50139648.00 | 12400128.00 | N |
| 2 | P-250300146000 | 0 | SD02 | SALES REGULAR | 2025-03-12 00:00:00.000 | K0046 | KARUNIA BERCA INDONESIA,PT | | 0 | KREDIT 14 HARI DGN JAMINAN BANK GIRO | LOCO GUDANG PT. KBK DIATAS TRUK | IDR | 2025-03-12 00:00:00.000 | 2025-03-31 00:00:00.000 | 9920.00 | 2830.00 | P-250300146000_Lampiran.pdf | V | 0 | U0312 | Channel (U | 8 | 3321.60 | 12750.00 | 9920.00 | 2830.00 | 42350400.00 | 9400128.00 | Y |
| 3 | T-250300007000 | 0 | SD02 | SALES REGULAR | 2025-03-12 00:00:00.000 | W0056 | WKI KBK KSO | | 0 | KREDIT 30 HARI | LOCO GUDANG PT. KBK DIATAS TRUK | IDR | 2025-03-12 00:00:00.000 | 2025-04-30 00:00:00.000 | 8978.36 | 217.45 | T-250300007000_Lampiran.pdf | V | 0 | P1935 | Polos P-38 | 19080 | 76434.48 | 10200.00 | 9600.00 | 600.00 | 779631696.00 | 45860688.00 | Y |

---

## Table: `DATA_KEC`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| KODE_PROVINSI | char | 2 | NO |
| KODE_KOTA | char | 2 | NO |
| KODE_KEC | char | 2 | NO |
| NAMA_KEC | varchar | 50 | NO |

### Sample Data (First 3 rows)
| KODE_PROVINSI | KODE_KOTA | KODE_KEC | NAMA_KEC |
| --- | --- | --- | --- |
| 11 | 01 | 01 | Bakongan |
| 11 | 01 | 02 | Kluet Utara |
| 11 | 01 | 03 | Kluet Selatan |

---

## Table: `DATA_KEL`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| KODE_PROVINSI | char | 2 | NO |
| KODE_KOTA | char | 2 | NO |
| KODE_KEC | char | 2 | NO |
| KODE_KEL | char | 4 | NO |
| NAMA_KEL | varchar | 50 | NO |

### Sample Data (First 3 rows)
| KODE_PROVINSI | KODE_KOTA | KODE_KEC | KODE_KEL | NAMA_KEL |
| --- | --- | --- | --- | --- |
| 12 | 12 | 22 | 2005 | Tangga Batu Barat |
| 12 | 12 | 22 | 2006 | Tangga Batu Timur |
| 12 | 12 | 23 | 2001 | Sihiong |

---

## Table: `DATA_KOTA`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| KODE_PROVINSI | char | 2 | NO |
| KODE_KOTA | char | 2 | NO |
| NAMA_KOTA | varchar | 50 | NO |

### Sample Data (First 3 rows)
| KODE_PROVINSI | KODE_KOTA | NAMA_KOTA |
| --- | --- | --- |
| 11 | 01 | Kabupaten Aceh Selatan |
| 11 | 02 | Kabupaten Aceh Tenggara |
| 11 | 03 | Kabupaten Aceh Timur |

---

## Table: `DATA_PROVINSI`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| KODE_PROVINSI | char | 2 | NO |
| NAMA_PROVINSI | varchar | 50 | NO |

### Sample Data (First 3 rows)
| KODE_PROVINSI | NAMA_PROVINSI |
| --- | --- |
| 11 | Aceh |
| 12 | Sumatera Utara |
| 13 | Sumatera Barat |

---

## Table: `DELIVERY_ORDER`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| ROWID | numeric | - | NO |
| DONO | char | 15 | NO |
| CONTRACTNO | char | 15 | NO |
| ADDENDUMNO | numeric | - | NO |
| TRANSTYPE | char | 4 | NO |
| DO_TYPE | varchar | 50 | YES |
| DO_DATE | datetime | - | YES |
| EXP_DATE | datetime | - | YES |
| DP | numeric | - | YES |
| TERMPAYMENT | varchar | 100 | YES |
| CUSTCODE | char | 8 | YES |
| CUSTOMER_NAME | varchar | 50 | YES |
| ENDUSER_NAME | varchar | 50 | YES |
| FILE_NAME | text | 2147483647 | YES |
| STATUS | char | 2 | YES |
| PRODID | char | 5 | YES |
| PRODUCT_NAME | varchar | 100 | YES |
| PIECES | decimal | - | YES |
| WEIGHT | decimal | - | YES |
| PRICE | decimal | - | YES |
| TOTAL_PRICE | decimal | - | YES |
| FLAG_UPDATE | char | 1 | YES |

### Sample Data (First 3 rows)
| ROWID | DONO | CONTRACTNO | ADDENDUMNO | TRANSTYPE | DO_TYPE | DO_DATE | EXP_DATE | DP | TERMPAYMENT | CUSTCODE | CUSTOMER_NAME | ENDUSER_NAME | FILE_NAME | STATUS | PRODID | PRODUCT_NAME | PIECES | WEIGHT | PRICE | TOTAL_PRICE | FLAG_UPDATE |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 4 | P-250100056001 | P-250100056000 | 0 | SD06 | SALES REGULAR | 2025-02-04 00:00:00.000 | 2025-03-31 00:00:00.000 | 0 | KREDIT 30 HARI | W0056 | WKI KBK KSO | | Validasi WKI.pdf | V | T0935 | Plate COIL 2.7MM X 312 X 4318 | 815217.00 | 815217.00 | 11600.00 | 9456517200.00 | Y |
| 5 | P-250200074001 | P-250200074000 | 0 | SD06 | SALES REGULAR | 2025-02-03 00:00:00.000 | 2025-03-31 00:00:00.000 | 100 | CASH BEFORE DELIVERY | I0007 | INTISUMBER BAJASAKTI, PT | | PERPANJANG DO.pdf | V | W0112 | Wide Flange 150x75x5 | 600.00 | 100800.00 | 11000.00 | 1108800000.00 | Y |
| 6 | T-241100058001 | T-241100058000 | 0 | SD06 | SALES REGULAR | 2024-11-29 00:00:00.000 | 2025-03-31 00:00:00.000 | 0 | KREDIT 30 HARI | W0056 | WKI KBK KSO | | Validasi WKI.pdf | V | S0143 | Sirip S-10 | 33900.00 | 250995.60 | 9150.00 | 2296609740.00 | Y |

---

## Table: `HISTORY_APPROVE`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| ROWID | numeric | - | NO |
| SEQNO | numeric | - | NO |
| CONTRACTNO | char | 20 | NO |
| TRANSTYPE | char | 4 | NO |
| ADDENDUMNO | numeric | - | YES |
| REGNO | char | 10 | YES |
| NAME | char | 50 | YES |
| JABATAN | text | 2147483647 | YES |
| DATE_APPROVE | datetime | - | YES |
| STATUS | char | 1 | YES |
| REMARK | text | 2147483647 | YES |
| TRANSGROUP | varchar | 10 | YES |
| DESCRIP | varchar | 50 | YES |

### Sample Data (First 3 rows)
| ROWID | SEQNO | CONTRACTNO | TRANSTYPE | ADDENDUMNO | REGNO | NAME | JABATAN | DATE_APPROVE | STATUS | REMARK | TRANSGROUP | DESCRIP |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 11 | 5 | 202503000249 | LS23 | 0 | 200272 | WIWI ROHMAYATI | LOGISTIC PLANNING & CONTROLLING STAFF ... | 2025-03-12 08:04:48.910 | A | NULL | REGULAR | DIBUAT |
| 19 | 6 | 202503000249 | LS23 | 0 | 200204 | RUSHIDI | SALES OPERATION & PLANNING MANAGER ... | 2025-03-13 08:06:54.180 | A | NULL | REGULAR | DIPERIKSA |
| 48 | 1 | 202503000303 | LM02 | 0 | 200231 | BADRI SALAM | BUSINESS DEVELOPMENT & COST CONTROL STAFF ... | 2025-03-13 11:12:14.580 | A | NULL | REGULAR | DIBUAT |

---

## Table: `PC`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| ROWID | numeric | - | NO |
| PCNO | char | 12 | NO |
| PRNO | char | 12 | NO |
| TRANSTYPE | char | 4 | NO |
| ADDENDUMNO | numeric | - | NO |
| PCDATE | datetime | - | YES |
| PCGROUP | char | 15 | YES |
| PCTYPE | varchar | 15 | YES |
| COSTCENTERID | char | 4 | YES |
| COSTCENTER_NAME | varchar | 150 | YES |
| RABNO | char | 15 | YES |
| PROJECT_NAME | varchar | 200 | YES |
| NOTE | varchar | 900 | YES |
| VENDORID | char | 5 | YES |
| VENDOR_NAME | varchar | 200 | YES |
| TERMPAYMENT | varchar | 200 | YES |
| TAX | varchar | 50 | YES |
| CURRENCY | varchar | 15 | YES |
| STATUS | char | 2 | YES |
| FILE_NM | varchar | 150 | YES |
| ITEM_ID | char | 15 | YES |
| ITEM_NAME | varchar | 900 | YES |
| DESCRIPTION | varchar | 900 | YES |
| UNIT | varchar | 50 | YES |
| BEG_DATE | datetime | - | YES |
| END_DATE | datetime | - | YES |
| PIECES | decimal | - | YES |
| WEIGHT | decimal | - | YES |
| PRICE_RAB | decimal | - | YES |
| PRICE_PC | decimal | - | YES |
| VARIAN | decimal | - | YES |
| TOTAL_VARIAN | decimal | - | YES |
| TOTAL_PC | decimal | - | YES |
| FLAG_UPDATE | char | 1 | YES |

### Sample Data (First 3 rows)
| ROWID | PCNO | PRNO | TRANSTYPE | ADDENDUMNO | PCDATE | PCGROUP | PCTYPE | COSTCENTERID | COSTCENTER_NAME | RABNO | PROJECT_NAME | NOTE | VENDORID | VENDOR_NAME | TERMPAYMENT | TAX | CURRENCY | STATUS | FILE_NM | ITEM_ID | ITEM_NAME | DESCRIPTION | UNIT | BEG_DATE | END_DATE | PIECES | WEIGHT | PRICE_RAB | PRICE_PC | VARIAN | TOTAL_VARIAN | TOTAL_PC | FLAG_UPDATE |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | 202503000297 | 202503000272 | LM07 | 0 | 2025-03-07 00:00:00.000 | REGULAR | SPARE PART | 5500 | CENTRAL MAINTENANCE DEPARTMENT | NULL | NULL | - KEBUTUHAN PERAWATAN - Repeat OrderPC No.: 2... | 17025 | KEMBA RINDO PRATAMA, PT | 45 HARI SETELAH INVOICE DITERIMA | Non Pajak | IDR | NULL | SPPH -23060-202503000232.pdf | 000000460 | ELECTRODA OK 46.00 DIA.3,2 MM, MANUFACTURE : ESSAB | NA | BO | NULL | NULL | 40.000 | .000 | .0000000 | 171000.0000000 | .0000000 | .0000000 | 6840000.0000000 | N |
| 2 | 202503000306 | 202502000248 | LM07 | 0 | 2025-03-11 00:00:00.000 | PROJECT | SPARE PART | 6400 | PROJECT & DOWNSTREAM PRODUCT OPERATIONS DEPARTMENT | NULL | NULL | - KEBUTUHAN PROJECT BAHODOPI 2 - ITEM NO 6 PEN... | 21063 | CV CITRA SEMANGAT MANDIRI | 45 HARI SETELAH INVOICE DITERIMA | Non Pajak | IDR | V | PCM202503000306_lampiran.PDF | 000013747 | Anchor Bolt M.20x480 Grade F1554 HDG (4 Nut + 3... | NA | SET | NULL | NULL | 120.000 | .000 | .0000000 | 84000.0000000 | .0000000 | .0000000 | 10080000.0000000 | Y |
| 3 | 202503000306 | 202502000248 | LM07 | 0 | 2025-03-11 00:00:00.000 | PROJECT | SPARE PART | 6400 | PROJECT & DOWNSTREAM PRODUCT OPERATIONS DEPARTMENT | NULL | NULL | - KEBUTUHAN PROJECT BAHODOPI 2 - ITEM NO 6 PEN... | 21063 | CV CITRA SEMANGAT MANDIRI | 45 HARI SETELAH INVOICE DITERIMA | Non Pajak | IDR | V | PCM202503000306_lampiran.PDF | 000014156 | Anchor Bolt M.16x200 Grade F1554 HDG (4 Nut + 3... | NA | SET | NULL | NULL | 240.000 | .000 | .0000000 | 50000.0000000 | .0000000 | .0000000 | 12000000.0000000 | Y |

---

## Table: `PR`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| ROWID | numeric | - | NO |
| PRNO | char | 12 | NO |
| TRANSTYPE | char | 4 | NO |
| ADDENDUMNO | numeric | - | NO |
| PRDATE | datetime | - | YES |
| PRGROUP | char | 15 | YES |
| PRTYPE | varchar | 15 | YES |
| COSTCENTERID | char | 4 | YES |
| COSTCENTER_NAME | varchar | 200 | YES |
| RABNO | char | 15 | YES |
| PROJECT_NAME | varchar | 100 | YES |
| ESTIMASI_COST | decimal | - | YES |
| NOTE | varchar | 400 | YES |
| USE_DATE | datetime | - | YES |
| STATUS | char | 2 | YES |
| ITEM_ID | char | 15 | YES |
| ITEM_NAME | varchar | 900 | YES |
| DESCRIPTION | varchar | 900 | YES |
| UNIT | char | 15 | YES |
| PIECES | decimal | - | YES |
| WIEGHT | decimal | - | YES |
| PRICE | decimal | - | YES |
| TOTAL_PRICE | decimal | - | YES |
| FILE_NAME | varchar | 100 | YES |
| FLAG_UPDATE | char | 1 | YES |

### Sample Data (First 3 rows)
| ROWID | PRNO | TRANSTYPE | ADDENDUMNO | PRDATE | PRGROUP | PRTYPE | COSTCENTERID | COSTCENTER_NAME | RABNO | PROJECT_NAME | ESTIMASI_COST | NOTE | USE_DATE | STATUS | ITEM_ID | ITEM_NAME | DESCRIPTION | UNIT | PIECES | WIEGHT | PRICE | TOTAL_PRICE | FILE_NAME | FLAG_UPDATE |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | 202503000303 | LM02 | 0 | 2025-03-10 00:00:00.000 | REGULAR | SPARE PART | 5500 | CENTRAL MAINTENANCE DEPARTMENT | NULL | NULL | 2000000.0000000 | NULL | 2025-04-30 00:00:00.000 | V | 000000642 | ELBOW STAINLESS STEEL 1" 90 DERAJAT SCH,40 | NULL | PCS | 10.000 | .0000000 | .0000000 | .0000000 | N/A | Y |
| 2 | 202503000305 | LM02 | 0 | 2025-03-10 00:00:00.000 | REGULAR | SPARE PART | 5500 | CENTRAL MAINTENANCE DEPARTMENT | NULL | NULL | 29800000.0000000 | NULL | 2025-04-30 00:00:00.000 | V | 000004055 | GEAR COUPLING ROLL TABLE STAND 1 DWG. GB-M-008-... | NULL | ST | 12.000 | .0000000 | .0000000 | .0000000 | N/A | Y |
| 3 | 202503000307 | LM02 | 0 | 2025-03-10 00:00:00.000 | REGULAR | SPARE PART | 5500 | CENTRAL MAINTENANCE DEPARTMENT | NULL | NULL | 5000000.0000000 | NULL | 2025-04-30 00:00:00.000 | V | 000014184 | FLANGE COUPLING ROLL TABLE STAND 2 SM (GB-M-014... | NULL | pcs | 5.000 | .0000000 | .0000000 | .0000000 | N/A | Y |

---

## Table: `sm_cbFunction`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| TransType | char | 1 | NO |
| FunctionID | char | 4 | NO |
| cb_1 | smallint | - | NO |
| cb_2 | smallint | - | NO |
| cb_3 | smallint | - | NO |
| cb_4 | smallint | - | NO |
| cb_5 | smallint | - | NO |
| cb_6 | smallint | - | NO |
| cb_7 | smallint | - | NO |
| cb_8 | smallint | - | NO |
| cb_9 | smallint | - | NO |
| cb_10 | smallint | - | NO |
| cb_11 | smallint | - | NO |
| cb_12 | smallint | - | NO |
| cb_13 | smallint | - | NO |
| cb_14 | smallint | - | NO |
| cb_15 | smallint | - | NO |

### Sample Data (First 3 rows)
| TransType | FunctionID | cb_1 | cb_2 | cb_3 | cb_4 | cb_5 | cb_6 | cb_7 | cb_8 | cb_9 | cb_10 | cb_11 | cb_12 | cb_13 | cb_14 | cb_15 |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| C | 0T13 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 |
| C | AC01 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 |
| C | AC02 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 | 0 |

---

## Table: `sm_cmdButton`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| FunctionID | char | 4 | NO |
| NoCommButton | numeric | - | YES |
| cb_1 | char | 20 | YES |
| cb_2 | char | 20 | YES |
| cb_3 | char | 20 | YES |
| cb_4 | char | 20 | YES |
| cb_5 | char | 20 | YES |
| cb_6 | char | 20 | YES |
| cb_7 | char | 20 | YES |
| cb_8 | char | 20 | YES |
| cb_9 | char | 20 | YES |
| cb_10 | char | 20 | YES |
| cb_11 | char | 20 | YES |
| cb_12 | char | 20 | YES |
| cb_13 | char | 20 | YES |
| cb_14 | char | 20 | YES |
| cb_15 | char | 20 | YES |

### Sample Data (First 3 rows)
| FunctionID | NoCommButton | cb_1 | cb_2 | cb_3 | cb_4 | cb_5 | cb_6 | cb_7 | cb_8 | cb_9 | cb_10 | cb_11 | cb_12 | cb_13 | cb_14 | cb_15 |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 0T13 | 0 | | | | | | | | | | | | | | | |
| AC01 | 0 | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL |
| AC02 | 0 | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL |

---

## Table: `sm_mailserver`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| MAILID | char | 10 | NO |
| HOST | char | 20 | NO |
| PORT | char | 10 | NO |
| USERID | char | 25 | NO |
| PASS | char | 20 | NO |
| DESCR | varchar | 50 | YES |
| EMAIL | varchar | 50 | YES |
| DEFTEMAIL | char | 1 | YES |
| EMAIL_BOD | varchar | 50 | YES |

### Sample Data (First 3 rows)
| MAILID | HOST | PORT | USERID | PASS | DESCR | EMAIL | DEFTEMAIL | EMAIL_BOD |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| SYSINFO | 192.14.3.13 | 25 | SYSINFO | KBKjaya2024 | EMAIL SYS INFO | sysinfo@bajakonstruksi.co.id | Y | NULL |

---

## Table: `sm_UserAdmin`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| REGNO | varchar | 100 | YES |

### Sample Data (First 3 rows)
| REGNO |
| --- |
| 200322 |

---

## Table: `sm_UserFunction`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| FunctionID | char | 4 | NO |
| UserID | char | 10 | NO |
| TransType | char | 1 | NO |

### Sample Data (First 3 rows)
| FunctionID | UserID | TransType |
| --- | --- | --- |
| AC01 | Admin | D |
| AC01 | handoko | R |
| AC01 | suryo | D |

---

## Table: `sm_UserID`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| UserID | char | 10 | NO |
| UGroup | char | 10 | NO |
| Language | char | 3 | NO |
| Password | char | 25 | NO |
| Creator | char | 25 | NO |
| RegisterNo | char | 10 | YES |
| Hash | varchar | 80 | YES |
| PassChg | date | - | YES |
| BlockStat | char | 1 | YES |
| SP | char | 1 | YES |
| HTSVersion | char | 6 | YES |
| LoginDate | datetime | - | YES |
| LoginSC | char | 1 | YES |
| device_token | text | 2147483647 | YES |
| NAME | varchar | 50 | YES |
| ABILITIES | varchar | 50 | YES |
| id | int | - | NO |
| IS_CUSTOMER | char | 1 | YES |
| IS_SALES | char | 1 | YES |
| IS_DISTRIBUTION | char | 1 | YES |
| CUSTCODE | char | 8 | YES |
| es_token | text | 2147483647 | YES |
| ESVersion | varchar | 100 | YES |
| otp_code | varchar | 6 | YES |
| otp_valid_time | datetime | - | YES |
| otp_valid_status | char | 1 | YES |
| updated_at | datetime | - | YES |
| email | varchar | 100 | YES |

### Sample Data (First 3 rows)
| UserID | UGroup | Language | Password | Creator | RegisterNo | Hash | PassChg | BlockStat | SP | HTSVersion | LoginDate | LoginSC | device_token | NAME | ABILITIES | id | IS_CUSTOMER | IS_SALES | IS_DISTRIBUTION | CUSTCODE | es_token | ESVersion | otp_code | otp_valid_time | otp_valid_status | updated_at | email |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| adarajatun | None | IND | adarajatun | Admin | 200161 | a7c4943142d0a2bde742c3a189a72a09ffa14e81 ... | 2023-12-11 | Y | NULL | NULL | 2024-04-03 15:19:05.953 | Y | NULL | NULL | NULL | 134 | NULL | NULL | NULL | NULL | NULL | NULL | NULL | NULL | N | NULL | nazwir8995@gmail.com |
| adhie | SPI | IND | idamhkar | Admin | 200268 | d00f6c705867e8f5230391b1d1b4c58759180d68 ... | 2025-01-22 | N | NULL | NULL | 2025-02-27 09:13:16.773 | Y | NULL | NULL | NULL | 122 | NULL | NULL | NULL | NULL | NULL | NULL | 233455 | 2025-03-25 15:03:13.000 | V | 2025-03-25 15:01:55.397 | nazwir8995@gmail.com |
| adhisetyo | None | IND | aurel | Admin | 200213 | d736f4f16183383a23e2d933262d7c795dcd05c8 ... | 2024-07-06 | Y | NULL | NULL | 2023-08-28 15:50:55.430 | Y | esthz4OoTni044Bqp4S3dH:APA91bF1rYM33HQND0LKv3xU... | NULL | NULL | 102 | NULL | NULL | NULL | NULL | fvYecU2vQomuUUFiBPeCjv:APA91bFyik_9uCEN0BZfHCfH... | 1.0.01 | 819526 | 2025-03-11 11:32:13.000 | V | 2025-03-11 11:36:30.680 | nazwir8995@gmail.com |

---

## Table: `sm_UserID_old`
### Schema
| Column | Type | Length | Nullable |
|---|---|---|---|
| UserID | char | 10 | NO |
| UGroup | char | 10 | NO |
| Language | char | 3 | NO |
| Password | char | 25 | NO |
| Creator | char | 25 | NO |
| RegisterNo | char | 10 | YES |
| Hash | char | 80 | YES |
| PassChg | date | - | YES |
| BlockStat | char | 1 | YES |
| SP | char | 1 | YES |
| HTSVersion | char | 6 | YES |
| LoginDate | datetime | - | YES |
| LoginSC | char | 1 | YES |
| device_token | text | 2147483647 | YES |
| NAME | varchar | 50 | YES |
| ABILITIES | varchar | 50 | YES |
| id | int | - | NO |
| IS_CUSTOMER | char | 1 | YES |
| IS_SALES | char | 1 | YES |
| IS_DISTRIBUTION | char | 1 | YES |
| CUSTCODE | char | 8 | YES |
| es_token | text | 2147483647 | YES |
| ESVersion | varchar | 100 | YES |
| otp_code | varchar | 6 | YES |
| otp_valid_time | datetime | - | YES |
| otp_valid_status | char | 1 | YES |
| updated_at | datetime | - | YES |
| email | varchar | 100 | YES |

### Sample Data (First 3 rows)
| UserID | UGroup | Language | Password | Creator | RegisterNo | Hash | PassChg | BlockStat | SP | HTSVersion | LoginDate | LoginSC | device_token | NAME | ABILITIES | id | IS_CUSTOMER | IS_SALES | IS_DISTRIBUTION | CUSTCODE | es_token | ESVersion | otp_code | otp_valid_time | otp_valid_status | updated_at | email |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| adhisetyo | None | IND | aurel | Admin | 200213 | 81ac7530920820fee6ba5136e3398cfb4729646e ... | 2024-07-06 | N | NULL | NULL | 2023-08-28 15:50:55.430 | Y | esthz4OoTni044Bqp4S3dH:APA91bF1rYM33HQND0LKv3xU... | NULL | NULL | 10934 | NULL | NULL | NULL | NULL | fvYecU2vQomuUUFiBPeCjv:APA91bFyik_9uCEN0BZfHCfH... | 1.0.01 | NULL | NULL | N | NULL | adhityo@bajakonstruksi.co.id ... |
| Admin | Admin | ENG | newsiwa2018 | System | 200322 | 64a59e063e3cfae86ea8e760c11abbd59da096d1 ... | 2024-10-31 | N | NULL | 1.0.12 | 2024-12-23 11:01:47.527 | Y | NULL | NULL | NULL | 10935 | NULL | NULL | NULL | NULL | cdrouACJTQ6tM47KQN0cqq:APA91bHwAYCqsfD1aPT23Iom... | 1.0.01 | 193585 | 2024-12-23 14:06:30.000 | V | 2024-12-24 18:05:46.257 | muha.ronny.chan@gmail.com |
| andieko | PRODUKSI | IND | 110101 | Admin | 200165 | 9f51c0244fda7606f4be3820caf49e7fd7c1ad0e ... | 2024-12-11 | N | NULL | NULL | 2024-12-11 16:28:20.813 | Y | d7ENXBvMSva8zSiZKONuwn:APA91bETI7RkPvaiRg3Q86oh... | NULL | NULL | 10936 | NULL | NULL | NULL | NULL | NULL | NULL | 821050 | 2024-12-26 15:06:08.000 | V | 2024-12-26 15:04:51.670 | fcbyana89@gmail.com |
