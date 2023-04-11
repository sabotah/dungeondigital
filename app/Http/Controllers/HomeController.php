<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

use Mail;
use App\Mail\Feedback;

use App\Models\Campaign;
use App\Models\User;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home')->with('user',\Auth::user());
    }

    public function discordCallback(Request $request){

        $output = $this->httpPost('http://localhost:3000', array('data' => 'some data'));
        echo $output;
        // PHP Side


        // $user = \Auth::user();
        // $user->discordid = $request->code;
        // $user->save();
        // var_dump($request->all());
        // return redirect('/home');
    }

    public function createDiscordChannel(Request $request) {
        if ($request->campaignid) {
            $thecode = $this->passCampaignToNode($request->campaignid);
            return $thecode;
        }
    }

    public function passCampaignToNode($campaignid) {
        $user = \Auth::user();
        $campaign = Campaign::find($campaignid);
        if ($user->id == $campaign->user_id) {
            if ($output = $this->httpPost('http://localhost:3000/createchannel', array('name' => $campaign->name))) {
                $array = json_decode($output,true);
                $campaign->discordchannelid = $array['channelid'];
                $campaign->save();
                return $array['code'];
            }
        }
    }

    public function passChannelIdToNode($discordchannelid) {
        if ($output = $this->httpPost('http://localhost:3000/getchannelinvite', array('channelid' => $discordchannelid))) {
            $array = json_decode($output,true);
            return $array['code'];
        }
    }

    public function httpPost($url,$params)
    {
        $postData = json_encode($params);

        // $postData = http_build_query($params);
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $output=curl_exec($ch);

        curl_close($ch);
        return $output;
    }

    public function textToVoice() {
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.getcwd().'DungeonDigitalCredential.json');
        // instantiates a client
        $client = new TextToSpeechClient();

        // sets text to be synthesised
        $synthesis_input = (new SynthesisInput())
            ->setText('you see a blood stained room, rats run under your feet as a loud roar is heard to the east. You tremble with fear');

        // build the voice request, select the language code ("en-US") and the ssml
        // voice gender
        $voice = (new VoiceSelectionParams())
            ->setName('en-GB-Wavenet-D')
            ->setLanguageCode('en-GB')
            ->setSsmlGender(SsmlVoiceGender::MALE);

        // select the type of audio file you want returned
        $audioConfig = (new AudioConfig())
            ->setAudioEncoding(AudioEncoding::MP3);

        // perform text-to-speech request on the text input with selected voice
        // parameters and audio file type
        $response = $client->synthesizeSpeech($synthesis_input, $voice, $audioConfig);
        $audioContent = $response->getAudioContent();

        // the response's audioContent is binary
        file_put_contents(getcwd().'storage/app/public/output.mp3', $audioContent);
        echo 'Audio content written to "output.mp3"' . PHP_EOL;
    }

    public function postFeedback(Request $request) {
        $feedback = $request->feedback;
        Mail::to(User::find(1))->send(new Feedback($feedback));
        return back()->with('success','Thankyou for your Feedback!');
    }
}
