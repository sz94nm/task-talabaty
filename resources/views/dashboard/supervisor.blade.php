@extends('layouts.master')
@section('content')

    <div class="container" id="app" xmlns:v-on="http://www.w3.org/1999/xhtml">

        {{--        tickets table   --}}
        <div class="row justify-content-center my-3">

            <div class="col">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <h2>pending tickets</h2>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <table class="table mw-100 ">
                            <thead>
                            <tr>
                                <th scope="col">Value</th>
                                <th scope="col">Addition</th>
                                <th scope="col">Subtraction</th>
                                <th scope="col">Multiplication</th>
                                <th scope="col">Division</th>
                                <th scope="col">Result</th>
                                <th scope="col">Archive</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr v-for="ticket in tickets">
                                <td>@{{ ticket.value }}</td>
                                <td>@{{ ticket.addition }}</td>
                                <td>@{{ ticket.subtraction }}</td>
                                <td>@{{ ticket.multiplication }}</td>
                                <td>@{{ ticket.division }}</td>
                                <td>@{{((ticket.value+ticket.addition)-ticket.subtraction)*ticket.multiplication}}</td>
                                <td>
                                    <button class="btn btn-primary form-control" id="submit"
                                            v-on:click="archiveTicket(ticket.id)">Archive
                                    </button>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>


        {{--        crud users--}}

        {{--        other operations areas--}}
    </div>
    <script>
        let vue = new Vue({
            el: '#app',
            data: {
                message: 'Hello Vue!',
                tickets: [],

            },

            methods: {
                fetchTickets: function () {
                    axios.get('/tickets')
                        .then(response=> {
                            // handle success
                            this.tickets = response.data;
                            console.log(response)
                        })
                },
                archiveTicket: function (id) {
                    axios.patch(`/tickets/${id}`, {
                        id: id,
                    })
                        .then(response => {
                            this.fetchTickets();
                            console.log(response);
                        })
                },
            },
            mounted() {
                this.fetchTickets();
                Echo.join('change')
                    .listen('TicketChanged', (event) => {
                        console.log(event.ticket);
                        this.tickets.push(event.ticket)
                    });
            },



        })

    </script>
@endsection
