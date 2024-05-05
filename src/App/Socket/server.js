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
const server = http.createServer(app).listen(PORT);
const io = socketIo(server);

io.on('connection', (socket) => {
    socket.on('join', (data) => {
        console.log(data);
        socket.join(data.socketKey);
    });

    socket.on('chat', (data) => {
        socket.to(data.socketKey).emit('read chat', data);
        console.log(data);
    });
});