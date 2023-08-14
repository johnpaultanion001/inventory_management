
@component('mail::message')
<style>
    .center {
            margin: auto;
            width: 100%;
            text-align: center;
            text-align: center;
            color: gray;
        }
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
        margin-top: 10px;
    }
    .col-6 {
        flex: 0 0 80%;
        max-width: 80%;
    }
    hr{
        border-top: .1em solid whitesmoke;
    }
</style>
<strong class="center" style="font-size: 20px;">{{ $content['msg'] }}</strong><br><br>
<div class="row">
    <div class="col-6">
        <strong style="font-size: 20px;">HUNTER HERO</strong><br>
        <strong style="font-size: 15px;">Brgy Lourdes , Antipolo City</strong>
        <br><br><br>
        <strong style="font-size: 15px;">{{ $content['name'] }}</strong><br>
        <strong style="font-size: 15px;">{{ $content['address'] }}</strong><br>
        <strong style="font-size: 15px;">{{ $content['contact_number'] }}</strong><br>
        <strong style="font-size: 15px;">{{ $content['email'] }}</strong>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <strong style="font-size: 12px;">Order # {{ $content['order_number'] }}  <br>  Placed On {{ $content['placed_on'] }} <br> <strong style="font-size: 15px;">{{ $content['delivery'] }}</strong></strong><br><br><br>
        <strong style="font-size: 15px;">Login into the website to more details. https://hunter-hero.com/</strong><br><br>
        <strong style="font-size: 12px;">Thank you! <br> We appreciate your business</strong>
    </div>
</div>


@endcomponent
