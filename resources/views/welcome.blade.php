@extends('layouts.master')
@section('content')

<div class="container" id="app" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="row justify-content-center my-3">
        <div class="col-auto">
            <h1>Hello there</h1>
        </div>
    </div>
    <div class="row justify-content-center my-3">
        <div class="col-auto">
            <h3>please submit a ticket!</h3>
        </div>
    </div>
    <div class="row justify-content-center my-3">
        <div class="col-md-2">
            <input type="number" class="form-control" v-model="ticketValue">
        </div>
        <div class="col-md-2">
            <button class="btn btn- btn-primary" v-on:click="submitTicket(ticketValue)">Submit</button>
        </div>
    </div>
</div>


<script>
    let vue = new Vue({
        el: '#app',
        data: {
            message: 'Hello Vue!',
            ticketValue:0 ,
        },

        methods: {
            submitTicket:function(ticketValue){
                axios.post('/tickets',{
                    value:ticketValue
                })
                    .then(function (response) {
                        // handle success
                        alert('ticket submitted')
                        console.log(response)

                    })
            },
        },


    })

</script>

@endsection
