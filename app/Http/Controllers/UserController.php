<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\User as User;

class UserController extends BaseController
{

  public function save(Request $request) {
    try {

      if(!$request->input('email') || !$request->input('phone'))
        throw new \Exception("É necessário um email e telefone válido", 1);

      $thereIs = User::where('email', $request->input('email'))->first();

      if($request->input('campaign'))
        $thereIs = User::where('email', $request->input('email'))->where('campaign', $request->input('campaign'))->first();


      if($thereIs && $thereIs->email)
        throw new \Exception("Você já faz parte! Se precisar alterar seus dados entre em contato pelo email teajudome@gmail.com, obrigado!", 1);


      if(!$request->input('location.lat') || !$request->input('location.lon'))
        throw new \Exception("Vá para o MAPA, Mova o PIN AMARELO, para atualizar sua localização", 1);



      $user = new User;
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->phone = $request->input('phone');
      $user->whatsapp = $request->input('whatsapp') !== null ? $request->input('whatsapp') : false;
      $user->slug = str_slug($request->input('name'));
      $user->address = '';
      $user->lat = $request->input('location.lat');
      $user->lng = $request->input('location.lon');
      $user->type = $request->input('type') ? $request->input('type') : 'volunteer';
      $user->city_id = 25;
      $user->campaign = $request->input('campaign') ? $request->input('campaign') : null;
      $user->options = $request->input('support') !== null ? json_encode($request->input('support')) : null;
      $user->status = 'a';
      $user->save();

      return response()->json(['status'=>true, 'message'=>'Inserido com sucesso!','data'=>[
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,
        'whatsapp' => $user->whatsapp,
        'lat' => $user->lat,
        'lng' => $user->lng,
        'options' => json_decode($user->options),
        'type' => $user->type
      ]]);

    } catch (\Exception $e) {
      return response()->json(['status'=>false,'message'=>$e->getMessage()]);
    }
  }
  public function saveStore(Request $request) {
    try {

      if(!$request->input('name') || !$request->input('phone'))
        throw new \Exception("É necessário um nome e telefone válido", 1);

      if(!$request->input('location.lat') || !$request->input('location.lon'))
        throw new \Exception("Vá para o MAPA, Mova o PIN AMARELO, para atualizar sua localização", 1);

      if($request->input('email'))
        $query = User::where('email', $request->input('email'));

      if(!$request->input('email')):
        $query = User::where('phone', $request->input('phone'))
        ->where('lat', $request->input('location.lat'))
        ->where('lng', $request->input('location.lon'));
      endif;

      $thereIs = $query->first();

      if($thereIs && $thereIs->phone)
        throw new \Exception("Você já faz parte! Se precisa alterar seus dados entre em contato pelo email teajudome@gmail.com, obrigado!", 1);



      $user = new User;
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->phone = $request->input('phone');
      $user->whatsapp = $request->input('whatsapp') !== null ? $request->input('whatsapp') : false;
      $user->slug = str_slug($request->input('name'));
      $user->address = $request->input('address') !== null ? $request->input('address') : false;
      $user->lat = $request->input('location.lat');
      $user->lng = $request->input('location.lon');
      $user->type = $request->input('type') ? $request->input('type') : 'store';
      $user->city_id = 25;
      $user->campaign = $request->input('campaign') ? $request->input('campaign') : null;
      $user->options = $request->input('support') !== null ? json_encode($request->input('support')) : null;
      $user->status = 'a';
      $user->save();

      return response()->json(['status'=>true, 'message'=>'Inserido com sucesso!','data'=>[
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,
        'whatsapp' => $user->whatsapp,
        'lat' => $user->lat,
        'lng' => $user->lng,
        'options' => json_decode($user->options),
        'type' => $user->type
      ]]);

    } catch (\Exception $e) {
      return response()->json(['status'=>false,'message'=>$e->getMessage()]);
    }
  }

  public function all(Request $request) {
    try {
      $data = [];

      if(!$request->input('lat') || !$request->input('lng') || !$request->input('distance'))
        throw new \Exception("Error Processing Request", 1);

      $total = User::count();

      $payload = User::nearby([
        'lat' => $request->input('lat'),
        'lng' => $request->input('lng'),
        'distance' => $request->input('distance'),
        'limit' => 200
      ]);

      foreach($payload as $d):
        $data[] = [
          'name' => $d->name,
          'email' => $d->email,
          'phone' => $d->phone,
          'whatsapp' => $d->whatsapp,
          'lat' => $d->lat,
          'lng' => $d->lng,
          'options' => json_decode($d->options),
          'type' => $d->type
        ];

      endforeach;

      return response()->json(['status'=>true, 'message'=>'Dados coletados','data'=>$data,'total'=>$total]);
    } catch (\Exception $e) {
      return response()->json(['status'=>false,'message'=>$e->getMessage()]);
    }
  }


  public function allByCampaign(Request $request) {
    try {
      $data = [];

      if(!$request->input('lat') || !$request->input('lng') || !$request->input('distance') || !$request->input('campaign'))
        throw new \Exception("Error Processing Request", 1);
    
      $total = User::where('campaign', $request->input('campaign'))->count();

      $payload = User::nearby([
        'lat' => $request->input('lat'),
        'lng' => $request->input('lng'),
        'distance' => $request->input('distance'),
        'limit' => 200,
        'campaign' => $request->input('campaign') ? $request->input('campaign') : null,
      ]);

      foreach($payload as $d):
        $data[] = [
          'name' => $d->name,
          'email' => $d->email,
          'phone' => $d->phone,
          'whatsapp' => $d->whatsapp,
          'lat' => $d->lat,
          'lng' => $d->lng,
          'options' => json_decode($d->options),
          'type' => $d->type,
          'campaign' => $d->campaign
        ];

      endforeach;

      return response()->json(['status'=>true, 'message'=>'Dados coletados','data'=>$data,'total'=>$total]);
    } catch (\Exception $e) {
      return response()->json(['status'=>false,'message'=>$e->getMessage()]);
    }
  }


}
