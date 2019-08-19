@extends('layouts.master')
@section('content')

    <div class="container" id="app" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="row justify-content-center my-3">
            <div class="col">

                <div class="row justify-content-center">
                    <div class="col-auto">
                        <h2>Hello @{{ status }} User</h2>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">

                        <table class="table mw-100 ">
                            <thead>
                            <tr>
                                <th scope="col">ticket</th>
                                <th scope="col">amount</th>
                                <th scope="col">submit</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr v-for="ticket in tickets">

                                <td v-if="status=='add'">@{{ ticket.ticketAtAdd }}</td>
                                <td v-if="status=='sub'">@{{ ticket.ticketAtSub }}</td>
                                <td v-if="status=='mul'">@{{ ticket.ticketAtMul }}</td>
                                <td v-if="status=='div'">@{{ ticket.ticketAtDiv }}</td>
                                <td><input type="number" class="form-control" v-model="amount[ticket.id]"></td>
                                <td>
                                    <button class="btn btn-primary form-control" id="submit"
                                            v-on:click="updateTicket(ticket.id,amount[ticket.id])">Submit
                                    </button>
                                </td>
                            </tr>

                            </tbody>
                        </table>


                    </div>
                </div>


            </div>
        </div>


    </div>

    <script>
        let vue = new Vue({
            el: '#app',
            data: {
                message: 'Hello Vue!',
                tickets: [],
                status: '',
                amount: [],
                // echo:null,
            },

            methods: {
                fetchTickets: function () {
                    axios.get('/tickets')
                        .then(response => {
                            // handle success

                            this.status = response.data.status;
                            this.tickets = response.data.tickets;
                            console.log(response.data);
                        })
                },
                updateTicket: function (id, amount) {
                    axios.patch(`/tickets/${id}`, {
                        id: id,
                        amount: amount,
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
