<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
class FormulaSheetImport implements WithHeadings, WithMapping, WithTitle
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return ['id','name'];
    }

    public function map($row): array
    {
        return [
                "A" => "='first-term-exam'!AA2",
              "B" => "='first-term-exam'!AC2",
              "C" => "='first-term-exam'!AE2",
              "D" => "='first-term-exam'!AG2",
              "E" => "='first-term-exam'!AB2",
              "F" => "='first-term-exam'!AD2",
              "G" => "='first-term-exam'!AF2",
              "H" => "='first-term-exam'!AH2",
              "I" => "=SUM(B2,F2)",
              "J" => "=SUM(C2,G2)",
              "K" => "=SUM(D2,H2)",
              "L" => "=SUM(E2,I2)",
              "M" => "='first-term-exam'!AI2",
              "N" => "='first-term-exam'!AJ2",
              "O" => "='first-term-exam'!AK2",
              "P" => "=SUM(J2:M2)",
              "Q" => "=IFERROR(ROUND(IF(U2='Passed',Q2/4,"-"),2),"-")",
              "R" => "=IF(U2='Passed',IF(R2>=60, '1st',IF(R2>=45,'2nd',IF(R2>=33,'3rd',"-"))),"-")",
              "S" => "=IFERROR(ROUND(IF(U2='Passed',SUMPRODUCT((R2<=\$AO$2:\$AO$39)/COUNTIF(\$AO$2:\$AO$39,\$AO$2:$AO$39)),"-")-1,0),"-")",
              "T" => "=IF(OR(COUNTIF(B2:I2,'Abs')>=1,COUNTIF(B2:I2,'Ab')>=1,COUNTIF(B2:I2,'A')>=1,COUNTIF(B2:E2,\"<26.4\")>=1,COUNTIF(F2:I2,\"<6.6\")>=1),\"Failed\",\"Passed\")",
              "U" => "='first-term-exam'!AL2",
              "V" => "='first-term-exam'!AM2",
              "W" => "='second-term'!Z2",
              "X" => "='second-term'!AB2",
              "Y" => "='second-term'!AD2",
              "Z" => "='second-term'!AF2",
              "AA" => "='second-term'!AA2",
              "AB" => "='second-term'!AC2",
              "AC" => "='second-term'!AE2",
              "AD" => "='second-term'!AG2",
              "AE" => "=SUM(X2,AB2)",
              "AF" => "=SUM(Y2,AC2)",
              "AG" => "=SUM(Z2,AD2)",
              "AH" => "=SUM(AA2,AE2)",
              "AI" => "='second-term'!AH2",
              "AJ" => "='second-term'!AI2",
              "AK" => "='second-term'!AJ2",
              "AL" => "=SUM(AF2:AI2)",
              "AM" => "=IFERROR(ROUND(IF(AQ2=\"Passed\",AM2/4,"-"),2),"-")",
              "AN" => "=IF(AQ2=\"Passed\",IF(AN2>=60, \"1st\",IF(AN2>=45,\"2nd\",IF(AN2>=33,\"3rd\","-"))),"-")",
              "AO" => "=IFERROR(ROUND(IF(AQ2=\"Passed\",SUMPRODUCT((AN2<=\$AO$2:\$AO$39)/COUNTIF(\$AO$2:\$AO$39,\$AO$2:\$AO$39)),"-")-1,0),"-")",
              "AP" => "=IF(OR(COUNTIF(X2:AE2,\"Abs\")>=1,COUNTIF(X2:AE2,\"Ab\")>=1,COUNTIF(X2:AE2,\"A\")>=1,COUNTIF(X2:AA2,\"<26.4\")>=1,COUNTIF(AB2:AE2,\"<6.6\")>=1),\"Failed\",\"Passed\")",
              "AQ" => "='second-term'!AK2",

              "a45" => "='annual-exam'!E2",
              "a46" => "='annual-exam'!G2",
              "a47" => "='annual-exam'!I2",
              "a48" => "='annual-exam'!K2",
              "a49" => "='annual-exam'!F2",
              "a50" => "='annual-exam'!H2",
              "a51" => "='annual-exam'!J2",
              "a52" => "='annual-exam'!L2",
              "a53" => "=SUM(AT2,AX2)",
              "a54" => "=SUM(AU2,AY2)",
              "a55" => "=SUM(AV2,AZ2)",
              "a56" => "=SUM(AW2,BA2)",
              "a57" => "='annual-exam'!M2",
              "a58" => "='annual-exam'!N2",
              "a59" => "='annual-exam'!O2",
              "a60" => "=SUM(BB2:BE2)",
              "a61" => "=IFERROR(ROUND(IF(BM2=\"Passed\",BI2/4,"-"),2),"-")",
              "a62" => "=IF(BM2=\"Passed\",IF(BJ2>=60, \"1st\",IF(BJ2>=45,\"2nd\",IF(BJ2>=33,\"3rd\","-"))),"-")",
              "a63" => "=IFERROR(ROUND(IF(BM2=\"Passed\",SUMPRODUCT((BJ2<=\$CG$2:\$CG$39)/COUNTIF(\$CG$2:\$CG$39,\$CG$2:\$CG$39)),"-")-1,0),"-")",
              "a66" => "='annual-exam'!P2"
        ];

    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Sheet1';
    }

}
