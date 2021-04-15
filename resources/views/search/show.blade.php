@extends('layouts.app')

@section ('tittle', 'AlVenta | Resultados de la Búsqueda')

@section ('body-class', 'profile-page sidebar-collapse')

@section('content')
<div class="page-header header-filter" data-parallax="true" style="background-image: url('{{asset('img/ecommerce.jpg')}}')">
</div>

<div class="main main-raised">
    <div class="profile-content">
        <div class="container">

            <div class="row">
                <div class="col-md-6 ml-auto mr-auto">
                    <div class="profile">
                        <div class="avatar">
                            <img src="/img/search.jpg" alt="Imagen representativa de la búsqueda" class="img-raised rounded-circle img-fluid">
                        </div>
                        <div class="name">
                            <h3 class="title">Resultados de la Búsqueda</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="description text-center">
                <p>Se encontraron {{ $productsCount }} resultados de la búsqueda de {{ $query }}.</p>
            </div>

            @if (session('notification'))
            <div class="alert alert-success" role="alert">
                {{ session('notification') }}
            </div>
            @endif

            <div class="section text-center">
                <div class="team">
                    <div class="row">
                        @foreach($products as $product)

                        <div class="col-md-4">
                            <div class="team-player">
                                <div class="card card-plain">
                                    <div class="col-md-6 ml-auto mr-auto">
                                        <img src="{{ asset($product->featured_image_url) }}" alt="Thumbnail Image" class="img-raised rounded-circle img-fluid">
                                    </div>
                                    <h4 class="card-title">
                                        <a href="{{ url('/products/'.$product->id) }}">{{$product -> name}}</a>
                                    </h4>
                                    <div class="card-body">
                                        <p class="card-description">{{$product -> description}}</p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        @endforeach
                    </div>

                    <div class="links-paginate">
                        <!--Tambien se puede aplicar el estilo text-center solamente ya que no es necesario el row, pero lo dejo para ocular la seccion STYLE de la parte superior-->
                        {{ $products->links() }}

                    </div>

                </div>


            </div>



        </div>
    </div>
</div>

@include('includes.footer')

@endsection