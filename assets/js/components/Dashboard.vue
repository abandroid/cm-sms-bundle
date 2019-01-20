<template>
    <div class="row">
        <div class="col-md-12">
            <b-alert variant="success"
                     dismissible
                     :show="showSuccessAlert"
                     @dismissed="showSuccessAlert=false">
                {{ successMessage }}
            </b-alert>
            <b-alert variant="danger"
                     dismissible
                     :show="showDangerAlert"
                     @dismissed="showDangerAlert=false">
                {{ dangerMessage }}
            </b-alert>
            <div class="box">
                <div class="box-body">
                    <form class="form-inline">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Phone number" v-model="phoneNumber" />&nbsp;
                            <button type="button" class="btn btn-primary" v-on:click="sendTest">Send test</button>&nbsp;
                            <button type="button" class="btn btn-success" v-on:click="loadState">Refresh</button>
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
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="message in messages">
                            <td :class="getStyleForStatus(message.status_translation_key)">{{ message.date_created }}</td>
                            <td :class="getStyleForStatus(message.status_translation_key)">{{ message.date_updated }}</td>
                            <td :class="getStyleForStatus(message.status_translation_key)">{{ message.id }}</td>
                            <td :class="getStyleForStatus(message.status_translation_key)">{{ message.body }}</td>
                            <td :class="getStyleForStatus(message.status_translation_key)">{{ message.recipients }}</td>
                            <td :class="getStyleForStatus(message.status_translation_key)">{{ message.status_translation_key }}</td>
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
        name: 'dashboard',
        data: function () {
            return {
                messages: [],
                phoneNumber: '0000000000',
                showSuccessAlert: false,
                successMessage: '',
                showDangerAlert: false,
                dangerMessage: ''
            }
        },
        methods: {
            getStyleForStatus: function (status) {
                let style = 'table-warning';

                switch (status) {
                    case 'delivered':
                        style = 'table-success';
                        break;
                    case 'unsent':
                    case 'rejected':
                    case 'failed':
                        style = 'table-danger';
                        break;
                    default:
                        break;
                }

                return style;
            },
            loadState: function () {
                axios.get('/cm-sms/message').then((response) => {
                    this.messages = response.data.messages;
                }, (error) => {
                    this.dangerMessage = 'State could not be loaded';
                    this.showDangerAlert = true;
                })
            },
            sendTest: function () {
                axios.get('/cm-sms/message/send/' + this.phoneNumber).then((response) => {
                    this.successMessage = 'Message sent to ' + this.phoneNumber;
                    this.showSuccessAlert = true;
                    this.loadState();
                }, (error) => {
                    this.dangerMessage = 'Message could not be sent';
                    this.showDangerAlert = true;
                    this.loadState();
                })
            }
        },
        mounted: function () {
            // this.$alert.setDefault({
            //     duration: 100000
            // });
            this.loadState();
        }
    }
</script>

<style>
    .fade {
        opacity: 1;
    }
</style>