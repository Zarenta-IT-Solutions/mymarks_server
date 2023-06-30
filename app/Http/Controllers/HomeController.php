<?php

namespace App\Http\Controllers;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\WorkbookRange;
use Microsoft\Graph\Model\WorkbookWorksheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Mail;
use App\Models\Tenant;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Artisan;
use Microsoft\Graph\Connect\Constants;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcomes');
    }

    public function token()
    {
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId' => '1941fed0-b8c9-43f4-bdda-12edaea24d28',
            'clientSecret' =>'98v8Q~QLp9bDuZ7d1yE_Zp~zYw5UO8NjaWqjyafN',
            'redirectUri'             => 'https://mymarks.in/token',
            'urlAuthorize'            => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '',
            'scopes'                  => 'profile openid files.readwrite'
        ]);

        if (!\request()->has('code')) {
            $authorizationUrl = $provider->getAuthorizationUrl();
            header('Location: ' . $authorizationUrl);
            exit();
        } elseif (\request()->has('code')) {
            // With the authorization code, we can retrieve access tokens and other data.
            try {
                // Get an access token using the authorization code grant
                $accessToken = $provider->getAccessToken('authorization_code', ['code'=> \request()->code]);
                $token = $accessToken->getToken();
                $expire_at = Carbon::createFromTimestamp($accessToken->getExpires());
                $data = ['token'=>$token,'expire_at'=>$expire_at];

                Storage::disk('public')->put('msGraph.json', json_encode($data));


//                return setSettingVal($data);

            } catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                echo 'Something went wrong, couldn\'t get tokens: ' . $e->getMessage();
            }
            return redirect('/');
        }
    }

    public function excel()
    {
        $token = json_decode(Storage::disk('public')->get('msGraph.json'))->token;
        // Get the access token
        $accessToken = $token;

        // Create the request body
        $body = [
            'name' => 'test.xlsx',
            'file' => [
                'type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'content' => base64_encode(file_get_contents('test.xlsx')),
            ],
        ];

        // Make the request to the Microsoft Graph API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->post('https://graph.microsoft.com/v1.0/me/drive/root/children', $body);

        // Check the response status code
        if ($response->status() === 201) {
            // The Excel sheet has been created successfully
            return redirect()->route('excel.index');
        } else {
            // An error has occurred
            return view('excel.create')->withErrors($response->json());
        }
    }
    public function whatspp()
    {
        $token = \request()->waId;
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://example.authlink.me',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "waId":"'.$token.'"
            }',
          CURLOPT_HTTPHEADER => array(
            'clientId: k3k7gs3b',
            'clientSecret: lvj5gugfanhjy7qs',
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        dd($response);

    }

    public function sitemap()
    {
        $tenants = Tenant::all();
        return response()->view('sitemap',compact('tenants'))->header('Content-Type','text/xml');
    }
    public function checkSchool($school)
    {
//        \DB::disconnect('mysql');
//        \Config::set('database.connections.mysql.database', 'marks_EVS');
//        \DB::reconnect();
//        $marks = Marks::where('exam_id',7)->where('academic_year_id',1)->pluck('calculate_data');
//        foreach($marks as $k=>$mark){
//            $user = User::where('id',$mark['id'])->select('name','email','password','address','mobile','date_of_birth','current_academic_year_id','gender','about','avatar','address','blood_group','mother_name','father_name','aadhar','cast','family_id','sssm_id','rte','rte_number','enrollment','scholar','bank_name','bank_ifsc','bank_account','sambal')->first()->toArray();
//            $acedmic = StudentAcademicYear::where('user_id',$mark['id'])->where('academic_id',1)->first();
//            $marks[$k] = array_merge($user,array('roll_number'=>$acedmic->roll_number),$marks[$k]);
//
//        }
//        return response()->json($marks, 200);

        return DB::table('domains')->where('tenant_id',$school)->count();
    }

    public function school()
    {
        return view('thames.aislin.page')->with('title','Gyan');
    }

    public function school_page()
    {
        return view('thames.aislin.about')->with('title','Gyan');
    }
    public function school_contact()
    {
        return view('thames.aislin.contact')->with('title','Gyan');
    }
    public function school_blog()
    {
        return view('thames.aislin.blog')->with('title','Gyan');
    }
    public function school_blog_single()
    {
        return view('thames.aislin.blog_single')->with('title','Gyan');
    }

    public function admin(Request $request)
    {
        if($request->getHttpHost()!='mymarks.in')
        {
            return view('tenancy.admin');
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
