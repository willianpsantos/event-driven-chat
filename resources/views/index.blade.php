@extends('layout.main')

@section('content')
    <sidebar></sidebar>

    <div class="main">
        <transition name="fade">
            <router-view></router-view>
        </transition>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    window.mainElement = document.body.querySelector('.main');
</script>
@endsection
