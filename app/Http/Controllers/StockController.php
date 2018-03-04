<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class StockController extends Controller
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
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $users = User::all();

      $stocks = stock::orderBy('name', 'asc')->get();

      return View('stocks.show-stocks', compact('stocks', 'users'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      return view('stocks.add-stock');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $input = Input::only('name', 'link', 'notes', 'status');

      $validator = Validator::make($input, stock::rules());

      if ($validator->fails()) {
          $this->throwValidationException(
              $request, $validator
          );

          return redirect('stocks/create')->withErrors($validator)->withInput();
      }

      $stock = stock::create([
          'category'      => $request->input('category'),
          'name'          => $request->input('name'),
          'price'         => $request->input('price'),
          'shop'          => $request->input('shop'),
          'purchase_date' => $request->input('purchase_date'),
          'balance'       => $request->input('balance'),
          'rank'          => $request->input('rank'),
          'is_sync'       => $request->input('is_sync'),
          'is_show'       => $request->input('is_show'),
      ]);

      $stock->save();

      return redirect('stocks/'.$stock->id)->with('success', trans('stocks.createSuccess'));
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      $stock = stock::find($id);
      $users = User::all();
      $stockUsers = [];

      foreach ($users as $user) {
          if ($user->profile && $user->profile->stock_id === $stock->id) {
              $stockUsers[] = $user;
          }
      }

      $data = [
          'mdlStock'        => $stock,
          'stockUsers'      => $stockUsers,
      ];

      return view('stocks.show-stock')->with($data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      $stock = stock::find($id);
      $users = User::all();
      $stockUsers = [];

      foreach ($users as $user) {
          if ($user->profile && $user->profile->stock_id === $stock->id) {
              $stockUsers[] = $user;
          }
      }

      $data = [
          'stock'        => $stock,
          'stockUsers'   => $stockUsers,
      ];

      return view('stocks.edit-stock')->with($data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int                      $id
   *
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      $stock = stock::find($id);

      $input = Input::only('name', 'link', 'notes', 'status');

      $validator = Validator::make($input, stock::rules($id));

      if ($validator->fails()) {
          $this->throwValidationException(
              $request, $validator
          );

          return redirect('stocks/'.$stock->id.'/edit')->withErrors($validator)->withInput();
      }

      $stock->fill($input)->save();

      return redirect('stocks/'.$stock->id)->with('success', trans('stocks.updateSuccess'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      $default = stock::findOrFail(1);
      $stock = stock::findOrFail($id);

      if ($stock->id != $default->id) {
          $stock->delete();

          return redirect('stocks')->with('success', trans('stocks.deleteSuccess'));
      }

      return back()->with('error', trans('stocks.deleteSelfError'));
  }

  public function template()
  {
      return View('stocks.template');
  }
}
