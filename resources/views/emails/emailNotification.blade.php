
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
        <strong style="font-size: 20px;">TESTING LOGO</strong><br>
        <strong style="font-size: 15px;">sample addres test test</strong>
        <br><br><br>
        <strong style="font-size: 15px;">CODE: {{ $content['code'] }}</strong><br>
        <strong style="font-size: 15px;">DESC: {{ $content['description'] }}</strong><br>
        <strong style="font-size: 15px;">STOCK: {{ $content['stock'] }}</strong><br>
        <strong style="font-size: 15px;">UPDATED BY: {{ $content['updated_by'] }}</strong><br>
    </div>
</div>
<div class="row">
    <div class="col-6">
         <strong style="font-size: 15px;">Login into the website to more details. https://test.com/</strong><br><br>
        <strong style="font-size: 12px;">Thank you! <br> test email</strong>
    </div>
</div>


@endcomponent
