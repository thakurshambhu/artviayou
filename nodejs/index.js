'use strict';

const express = require('express');
const http = require('http');
const socketio = require('socket.io');
const socketEvents = require('./utils/socket');

class Server {
        constructor() {
                this.port = process.env.PORT || 4000;
        this.host = process.env.HOST || `localhost`;

        this.app = express();
        this.app.get('/test',(req, res)=>{
            res.json({'msg' : 'test test run'})
        })
        this.http = http.Server(this.app);
        this.socket = socketio(this.http);
        }

        appRun(){
                new socketEvents(this.socket).socketConfig();
                this.app.use(express.static(__dirname + '/uploads'));
        this.http.listen(4000, () => {
            console.log(`Listening on http://${this.host}:${this.port}`);
        });
    }
}

const app = new Server();
app.appRun();
