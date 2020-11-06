@extends('principal')
@section('contenido')

    @if(Auth::check())
            @if (Auth::user()->idrol == 1)
            <template v-if="menu==0">
                <h1>Escritorio</h1>
            </template>

            <template v-if="menu==4">
                <accesorio></accesorio>
            </template>

            <template v-if="menu==64">
                <user></user>
            </template>

            <template v-if="menu==8">
                <rol></rol>
            </template>

            @elseif (Auth::user()->idrol == 2)
            <template v-if="menu==5">
                <venta></venta>
            </template>

            <template v-if="menu==6">
                <cliente></cliente>
            </template>
            <template v-if="menu==10">
                <h1>Reporte de ventas</h1>
            </template>

            <template v-if="menu==11">
                <h1>Ayuda</h1>
            </template>

            <template v-if="menu==12">
                <h1>Acerca de</h1>
            </template>

            @elseif (Auth::user()->idrol == 3)

            <template v-if="menu==76">
                <red></red>
            </template>
   
            @else

            @endif

    @endif
       
        
    @endsection