<?php

namespace App\msGraph;

use Illuminate\Support\Facades\Storage;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Microsoft\Graph\Model\WorkbookRange;
use Microsoft\Graph\Model\WorkbookWorksheet;

class Workbook
{

    public function __construct()
    {
        $this->token = json_decode(Storage::disk('public')->get('msGraph.json'));
        $this->graph = new Graph();
        $this->graph->setAccessToken($this->token[0]->token);
    }

    public function getSheet($id,$sheetName,$range)
    {
        // 3. Define the API endpoint for your Excel sheet
        $endpoint = "/me/drive/items/$id/workbook/worksheets('$sheetName')/range(address='$range')";

            // 5. Send a GET request to the API endpoint to retrieve the data
            $data = $this->graph->createRequest("GET", $endpoint)
                ->setReturnType(WorkbookRange::class)
                ->execute();
            $data = $data->getValues();
            $headers = array_shift($data);
            $result = [];
            foreach ($data as $row) {
                if ($row[0] != "") {
                    $result[] = array_combine($headers, $row);
                }
            }
            return $result;

    }

    public function getSheetList($id)
    {
        $workbook = $this->graph->createRequest("GET", "/workbook/workbooks/$id")
            ->setReturnType(Model\Workbook::class)
            ->execute();

// Get the list of sheets in the workbook
        return $workbook->getSheets();
    }

    public function clearSheet($id,$sheetName)
    {
        $this->graph->createRequest("DELETE", "/me/drive/items/$id/workbook/worksheets/$sheetName/Range(address='A1:XFD1048576')/clear")
            ->execute();
    }

    public function addSheet($id,$name)
    {
        $worksheet = new WorkbookWorksheet();
        $worksheet->setName($name);

        return $this->graph->createRequest("POST", "/me/drive/items/$id/workbook/worksheets")
            ->attachBody($worksheet)
            ->execute();
    }

    public function append($id, $sheetName ,$data)
    {
        $range = new WorkbookRange();
        $range->setAddress("A1");
        $range->setValues($data);

        $request = $this->graph->createRequest("POST", "/me/drive/items/$id/workbook/worksheets/$sheetName/Range(address='A1')")
            ->attachBody($range)
            ->execute();
    }

}
