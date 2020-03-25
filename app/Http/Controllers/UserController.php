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

      if($thereIs && $thereIs->email)
        throw new \Exception("Você já faz parte! Se precisar alterar sua localização entre em contato pelo email teajudome@gmail.com, obrigado!", 1);


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
      $user->options = $request->input('support') !== null ? json_encode($request->input('support')) : null;
      $user->status = 'a';
      $user->save();

      return response()->json(['status'=>true, 'message'=>'Inserido com sucesso!','data'=>$user]);

    } catch (\Exception $e) {
      return response()->json(['status'=>false,'message'=>$e->getMessage()]);
    }
  }

  public function all(Request $request) {
    try {
      $data = [];

      $payload = User::where('status','a')->get();


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

      return response()->json(['status'=>true, 'message'=>'Dados coletados','data'=>$data]);
    } catch (\Exception $e) {
      return response()->json(['status'=>false,'message'=>$e->getMessage()]);
    }
  }
}
