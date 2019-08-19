@extends('layouts.master')

@section('content')
    <div class="container my-3 " id="app" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <h3 class="my-0 ">Users</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body overflow-auto">
                        <table class="table mw-100 ">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="users!=null" v-for="user in users">
                                <td>@{{ user.name }}</td>
                                <td>@{{ user.email }}</td>
                                <td>@{{ user.role }}</td>
                                <td>@{{ user.email }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a :href="`/users/${user.id}/edit`" class=" btn-sm btn btn-primary">Edit
                                        </a>
                                        <button type="button" v-on:click="deleteUser(user.id)"
                                                class="btn btn-danger btn-sm">
                                            Delete
                                        </button>

                                    </div>
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
                users: null,
                id: null,
            },

            methods: {

                fetchUsers: function () {
                    axios.get('/users/all')
                        .then(response=>{
                        // handle success
                         this.users = response.data;
                        console.log(this.users) })



                },

                deleteUser: function (id) {
                    axios.delete(`/users/${id}/`, {})
                        .then(response=>{
                            // handle success
                            this.fetchUsers();
                            console.log(response)
                        })
                },


                editUser: function (id) {
                    axios.get(`/users/${id}/edit`, {})
                        .then(function (response) {
                            // handle success
                            console.log(response)
                        })
                },
            },
            mounted() {
                this.fetchUsers();
            },

        })

    </script>

@endsection






