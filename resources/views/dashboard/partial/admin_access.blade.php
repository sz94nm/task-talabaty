@extends('layouts.master')
@section('content')

    <div class="container my-3" id="app" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="row justify-content-center my-3">
            <div class="col">

                <div class="row justify-content-center">
                    <div class="col-auto text-center">
                        <div class="btn-group btn-group-lg btn-group-toggle" role="group">
                            <button type="button" class="btn btn-secondary" v-on:click="operation='add'">Add</button>
                            <button type="button" class="btn btn-secondary" v-on:click="operation='sub'">Sub</button>
                            <button type="button" class="btn btn-secondary" v-on:click="operation='mul'">Mul</button>
                            <button type="button" class="btn btn-secondary" v-on:click="operation='div'">Div</button>
                        </div>
                    </div>
                </div>


                <div class="row justify-content-center my-3">
                    <div class="col-auto">
                        <h2>@{{ operation }}</h2>
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


                            <tr v-if="operation=='add'" v-for="ticket in tickets">

                                <td v-if="ticket.status=='add'">@{{ ticket.value }}</td>
                                <td v-if="ticket.status=='add'"><input type="number" class="form-control"
                                                                       v-model="amount[ticket.id]"
                                    ></td>
                                <td v-if="ticket.status=='add'">
                                    <button class="btn btn-primary form-control" id="submit"
                                            v-on:click="updateTicket(ticket.id,amount[ticket.id])">Submit
                                    </button>
                                </td>
                            </tr>

                            <tr v-if="operation=='sub'" v-for="ticket in tickets">

                                <td v-if="ticket.status=='sub'">@{{ ticket.value+ticket.addition }}</td>
                                <td v-if="ticket.status=='sub'"><input type="number" class="form-control"
                                                                       v-model="amount[ticket.id]"
                                    ></td>
                                <td v-if="ticket.status=='sub'">
                                    <button class="btn btn-primary form-control" id="submit"
                                            v-on:click="updateTicket(ticket.id,amount[ticket.id])">Submit
                                    </button>
                                </td>
                            </tr>

                            <tr v-if="operation=='mul'" v-for="ticket in tickets">

                                <td v-if="ticket.status=='mul'">@{{
                                    (ticket.value+ticket.addition)-ticket.subtraction }}
                                </td>
                                <td v-if="ticket.status=='mul'"><input type="number" class="form-control"
                                                                       v-model="amount[ticket.id]"
                                    ></td>
                                <td v-if="ticket.status=='mul'">
                                    <button class="btn btn-primary form-control" id="submit"
                                            v-on:click="updateTicket(ticket.id,amount[ticket.id])">Submit
                                    </button>
                                </td>
                            </tr>

                            <tr v-if="operation=='div'" v-for="ticket in tickets">

                                <td v-if="ticket.status=='div'">@{{
                                    ((ticket.value+ticket.addition)-ticket.subtraction)*ticket.multiplication
                                    }}
                                </td>
                                <td v-if="ticket.status=='div'"><input type="number" class="form-control"
                                                                       v-model="amount[ticket.id]"
                                    ></td>
                                <td v-if="ticket.status=='div'">
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
                operation: 'add',
                amount: [],

            },

            methods: {


                fetchTickets: function () {
                    axios.get('/tickets/live')
                        .then(response => {
                            // handle success
                            this.tickets = response.data;
                            console.log(response.data)
                        })
                },
                updateTicket: function (id, amount) {
                    axios.patch(`/tickets/${id}`, {
                        id: id,
                        amount: amount,
                    })
                        .then(response => {
                            this.fetchTickets();
                            this.amount[id]='null';
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
