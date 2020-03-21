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
        //throw new \Exception("Mova o PIN AMARELO, para encontrar uma localização", 1);



      $user = new User;
      $user->name = $request->input('name');
      $user->email = $request->input('email');
      $user->phone = $request->input('phone');
      $user->whatsapp = $request->input('whatsapp');
      $user->slug = str_slug($request->input('name'));
      $user->address = $request->input('street');
      $user->lat = $request->input('location.lat');
      $user->lng = $request->input('location.lon');
      $user->type = 'volunteer';
      $user->city_id = 25;
      $user->options = json_encode($request->input('support'));
      $user->status = 'a';
      $user->save();

      $id = $user->id;

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
          'options' => json_decode($d->options)
        ];

      endforeach;

      return response()->json(['status'=>true, 'message'=>'Dados coletados','data'=>$data]);
    } catch (\Exception $e) {
      return response()->json(['status'=>false,'message'=>$e->getMessage()]);
    }
  }
}
