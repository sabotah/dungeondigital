<?php

namespace App\Models;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function roomentities(): HasMany
	{
	    return $this->hasMany(RoomEntity::class);
	}

	public function characters(): HasMany
	{
		return $this->hasMany(Character::class);
	}

	// public function charactersvisited()
	// {
	// 	return $this->hasMany('\App\CharacterRoom');
	// }

	public function creatures(): HasMany
	{
		return $this->hasMany(Creature::class);
	}

	public function campaigncreatures(): HasMany
    {
        return $this->hasMany(CampaignCreature::class);
    }

	public function extensions(): HasMany
	{
		return $this->hasMany(Extension::class);
	}

  public function createAudio() {
      if (isset($this->audio) && $this->audio !='') {
        unlink(getcwd().'/storage/audio/'.$this->audio);
        // remove the existing audio file
        $this->audio = null;
        $this->save();
        // also remove the path to it
      }
      $pathforgoogle = str_replace("public","",getcwd());
      putenv('GOOGLE_APPLICATION_CREDENTIALS='.$pathforgoogle.'/DungeonDigitalCredential.json');
      // instantiates a client
      $client = new TextToSpeechClient();

      // sets text to be synthesised
      $synthesis_input = (new SynthesisInput())
          ->setText($this->description);

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


      $audiostring = $this->id.'-'.chr(mt_rand(97, 122)).substr(md5(time()), 1).'.mp3';
      // the response's audioContent is binary
      file_put_contents(getcwd().'/storage/audio/'.$audiostring, $audioContent);
      // echo 'Audio content written to "output.mp3"' . PHP_EOL;
      return $audiostring;
  }

}
