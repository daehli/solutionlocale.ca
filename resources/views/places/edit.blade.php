@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Modifier <em>{{ $place->name }}</em></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route("places.update", ['place' => $place->slug]) }}">
                        @csrf
                        @method('put')

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">Nom</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $place->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="categories" class="col-md-3 col-form-label text-md-right">
                                Catégorie *
                            </label>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <ul class="categories tree">
                                        @foreach($categories as $category_first_level)
                                            <li>
                                                <input class="form-check-input"
                                                       name="categories[]"
                                                       type="checkbox"
                                                       id="inlineCategoryCheckbox{{ $category_first_level->id }}"
                                                       value="{{ $category_first_level->id }}"
                                                       @if($place->categories->contains($category_first_level->id)) CHECKED @endif>
                                                <label class="form-check-label"
                                                       for="inlineCategoryCheckbox{{ $category_first_level->id }}">
                                                    {{ $category_first_level->name }}
                                                </label>
                                                <ul>
                                                    @foreach($category_first_level->children as $category_second_level)
                                                        <li>
                                                            <input class="form-check-input"
                                                                   name="categories[]"
                                                                   type="checkbox"
                                                                   id="inlineCategoryCheckbox{{ $category_second_level->id }}"
                                                                   value="{{ $category_second_level->id }}"
                                                                   @if($place->categories->contains($category_second_level->id)) CHECKED @endif>
                                                            <label class="form-check-label"
                                                                   for="inlineCategoryCheckbox{{ $category_second_level->id }}">
                                                                {{ $category_second_level->name }}
                                                            </label>
                                                            <ul>
                                                              @foreach($category_second_level->children as $category_third_level)
                                                                  <li>
                                                                      <input class="form-check-input"
                                                                             name="categories[]"
                                                                             type="checkbox"
                                                                             id="inlineCategoryCheckbox{{ $category_third_level->id }}"
                                                                             value="{{ $category_third_level->id }}"
                                                                             @if($place->categories->contains($category_third_level->id)) CHECKED @endif>
                                                                      <label class="form-check-label"
                                                                             for="inlineCategoryCheckbox{{ $category_third_level->id }}">
                                                                          {{ $category_third_level->name }}
                                                                      </label>
                                                                  </li>
                                                              @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @error('categories')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{!! $message !!}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="placeType" class="col-md-3 col-form-label text-md-right">Type d'entreprise</label>

                            <div class="col-md-9">
                                @foreach(App\PlaceType::all() as $type)
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" name="placeType[]" type="checkbox" id="inlinePlaceTypeCheckbox{{ $type->id }}" value="{{ $type->id }}" @if($place->types->contains($type->id)) CHECKED @endif>
                                  <label class="form-check-label" for="inlinePlaceTypeCheckbox{{ $type->id }}">{{ $type->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deliveryType" class="col-md-3 col-form-label text-md-right">Modes de distribution</label>

                            <div class="col-md-9">
                                @foreach(App\DeliveryType::all() as $type)
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" name="deliveryType[]" type="checkbox" id="inlineDeliveryTypeCheckbox{{ $type->id }}" value="{{ $type->id }}" @if($place->delivery->contains($type->id)) CHECKED @endif>
                                  <label class="form-check-label" for="inlineDeliveryTypeCheckbox{{ $type->id }}">{{ $type->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deliveryType" class="col-md-3 col-form-label text-md-right">Adresse de l'entreprise *</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="inputAddress" placeholder="1234 rue de l'achat local" name="address[line1]" required="" value="{{ $place->address }}">
                                <input type="text" class="form-control mt-2" id="inputAddress2" placeholder="Appartement, no. de porte, etc. (optionnel) " name="address[line2]" value="{{ $place->address_2 }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputCity" class="col-md-3 col-form-label text-md-right">Ville *</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="inputCity" placeholder="Sainte-Geneviève-de-Batiscan" name="city" required="" value="{{ $place->city }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputProvince" class="col-md-3 col-form-label text-md-right">&nbsp;</label>

                            <div class="form-group col-md-6">
                                <label for="inputProvince">Province</label>
                                <input type="text" class="form-control" id="inputProvince" readonly="" value="Québec">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputPostalCode">Code postal *</label>
                                <input type="text" class="form-control" id="inputPostalCode" placeholder="H0H 0H0" name="postalCode" required="" value="{{ $place->postalCode }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hideAddress" class="col-md-3 col-form-label text-md-right">Adresse cachée ?</label>

                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" name="hideAddress" type="checkbox" id="inlineHideAddressCheckbox" @if($place->hide_address) CHECKED @endif>
                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                        Si votre entreprise n'a <b>pas</b> besoin d'afficher son adresse (par ex. : vente exclusivement en ligne), cochez cette case.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="region_id" class="col-md-3 col-form-label text-md-right">Région administrative</label>

                            <div class="col-md-9">
                                <select class="custom-select" name="region_id" id="region" autocomplete="off">
                                    @foreach(App\Region::all() as $region)
                                    <option value="{{ $region->id }}" @if($place->region_id == $region->id) selected="selected" @endif>{{ $region->name }}</option>
                                    @endforeach
                                </select>

                                @error('region')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @can('super_admin')
                        <div class="form-group row">
                            <label for="long" class="col-md-3 col-form-label text-md-right">Géoloc longitude</label>

                            <div class="col-md-9">
                                <input id="long" type="text" class="form-control @error('long') is-invalid @enderror" name="long" value="{{ $place->long }}" autocomplete="long" autofocus>

                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Seuls les utilisateurs ayant l'accès <code>super_admin</code> peuvent modifier et voir cette valeur.
                                </small>

                                @error('long')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lat" class="col-md-3 col-form-label text-md-right">Géoloc latitude</label>

                            <div class="col-md-9">
                                <input id="lat" type="text" class="form-control @error('lat') is-invalid @enderror" name="lat" value="{{ $place->lat }}" autocomplete="lat" autofocus>

                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Seuls les utilisateurs ayant l'accès <code>super_admin</code> peuvent modifier et voir cette valeur.
                                </small>

                                @error('lat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endcan
                        
                        <div class="form-group row">
                            <label for="phoneNumber" class="col-md-3 col-form-label text-md-right">No. de tél.</label>

                            <div class="col-md-9">
                                <input id="phoneNumber" type="text" class="form-control @error('phoneNumber') is-invalid @enderror" name="phoneNumber" value="{{ $place->phoneNumber }}" autocomplete="phoneNumber" autofocus>

                                @error('phoneNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="additionnalPhoneNumber" class="col-md-3 col-form-label text-md-right">No. de tél. add.</label>

                            <div class="col-md-9">
                                <input id="additionnalPhoneNumber" type="text" class="form-control @error('additionnalPhoneNumber') is-invalid @enderror" name="additionnalPhoneNumber" value="{{ $place->additionnalPhoneNumber }}" autocomplete="additionnalPhoneNumber" autofocus>

                                @error('additionnalPhoneNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">Courriel</label>

                            <div class="col-md-9">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $place->email }}" autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-md-3 col-form-label text-md-right">Adresse web</label>

                            <div class="col-md-9">
                                <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $place->url }}" autocomplete="url" placeholder="Ex.: https://solutionlocale.ca"  autofocus>

                                @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="facebook_url" class="col-md-3 col-form-label text-md-right">
                                    Adresse de page Facebook
                                </label>

                                <div class="col-md-9">
                                    <input id="facebook_url" type="text"
                                           class="form-control @error('facebook_url') is-invalid @enderror"
                                           name="facebook_url"
                                           value="{{ $place->facebook_url }}"
                                           placeholder="Ex.: https://www.facebook.com/Solutionlocale/" 
                                           autocomplete="facebook_url" autofocus>

                                    @error('facebook_url')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{!! $message !!}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="deliveryZone" class="col-md-3 col-form-label text-md-right">Secteur desservi pour la livraison</label>

                            <div class="col-md-9">
                                <textarea id="deliveryZone" class="form-control @error('deliveryZone') is-invalid @enderror" name="deliveryZone">{{ $place->deliveryZone }}</textarea>

                                @error('deliveryZone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <span class="col-md-5"></span>

                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
