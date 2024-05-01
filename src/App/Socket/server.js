const express = require('express');
const http = require('http');
const https = require('https');
const socketIo = require('socket.io');
const logger = require('winston');

require('dotenv').config()

logger.remove(logger.transports.Console);
logger.add(new logger.transports.Console, { colorize: true, timestamp: true });
logger.info('Socket Server is running');

const PORT = process.env.SOCKET_PORT || 3000;


const app = express();
const server = http.createServer(app).listen(3000);
const io = socketIo(server);

/*
io.on('connection', (socket) => {
    socket.on('chat', (data) => {
        io.emit('chat', data);
        console.log(data);
    });
});
*/

let users = {};
io.on('connection', (socket) => {
    socket.on('private_chat', (data) => {
        let room = getRoom(data.sender, data.recipient);
        users[data.sender].join("A");
        users[data.recipient].join("A");
        io.to("A").emit(data.message);
        //io.to().emit(data.message);
        //io.emit('chat', data.message);
        console.log(data);
        console.log(room);
    });
});

function getRoom(user1, user2) {
    // This function should return a string that is unique to user1 and user2.
    // For example, you could sort the user IDs and concatenate them.
    return [user1, user2].sort().join('-');
}