<template>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Phone number" onKeyUp={this.updatePhoneNumber} />
                            &nbsp;
                            <button type="button" class="btn btn-primary" onClick={() => this.sendTest(this.state.phoneNumber)}>Send test</button>
                            &nbsp;
                            <button type="button" class="btn btn-success" onClick={() => this.loadState()}>Refresh</button>
                        </div>
                    </form>
                    <br />
                    <table class="table table-bordered" id="message-list">
                        <thead>
                        <tr>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>ID</th>
                            <th>Body</th>
                            <th>Recipients</th>
                            <th>Translation</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="message in messages">
                            <td>{{ message.date_created }}</td>
                            <td>{{ message.date_updated }}</td>
                            <td>{{ message.id }}</td>
                            <td>{{ message.body }}</td>
                            <td>{{ message.recipients }}</td>
                            <td>{{ message.translation_key }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'application',
        data: function () {
            return {
                messages: []
            }
        },
        methods: {
            fetchArticles: function () {
                axios.get('/cm-sms/message').then((response) => {
                    this.messages = response.data.messages;
                }, (error) => {
                    console.log(error)
                })
            }
        },
        mounted: function () {
            this.fetchArticles()
        }
    }
</script>
