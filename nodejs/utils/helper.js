'user strict';

const DB = require('./db');
const path = require('path');
const fs = require('fs');

class Helper{

	constructor(app){
		this.db = DB;
	}

	async addSocketId(userId, userSocketId){
		try {
			return await this.db.query(`UPDATE users SET socket_id = ?, online= ? WHERE id = ?`, [userSocketId,'Y',userId]);
		} catch (error) {
			console.log(error);
			return null;
		}
	}

	async logoutUser(userSocketId){
		return await this.db.query(`UPDATE users SET socket_id = ?, online= ? WHERE socket_id = ?`, ['','N',userSocketId]);
	}

	getChatList(userId){
		try {
			return Promise.all([
				this.db.query(`SELECT users.id, users.name, users.socket_id, users.online, users.updated_at FROM users left join saved_artists as sa on sa.artist_id=users.id left join messages on messages.from_user_id = users.id WHERE (sa.user_id = ? or messages.to_user_id = ?) and (sa.user_id != sa.artist_id or messages.to_user_id!=messages.from_user_id) and (users.id != ?) GROUP BY users.id`, [userId,userId,userId])
			]).then( (response) => {
				return {
					chatlist : response[0]
				};
			}).catch( (error) => {
				console.warn(error);
				return (null);
			});
		} catch (error) {
			console.warn(error);
			return null;
		}
	}

	async insertMessages(params){
		try {
			// console.log(`UPDATE messages SET read_status = ? WHERE from_user_id = ? AND to_user_id = ? `,['read', params.toUserId, params.fromUserId]);
			let TESTasd = await this.db.query(`UPDATE messages SET read_status = ? WHERE from_user_id = ? AND to_user_id = ? `,
				['read', params.toUserId, params.fromUserId]
			);
			// console.log('Query', TESTasd);
			return await this.db.query("INSERT INTO messages (`type`, `file_format`, `file_path`, `from_user_id`,`to_user_id`,`message`, `date`, `time`, `ip`) values (?,?,?,?,?,?,?,?,?)", [params.type, params.fileFormat, params.filePath, params.fromUserId, params.toUserId, params.message, params.date, params.time,params.ip]
			);
		} catch (error) {
			console.warn(error);
			return null;
		}
	}

	async getMessages(userId, toUserId){
		try {
			let TESTasd = await this.db.query(`UPDATE messages SET read_status = ? WHERE from_user_id = ? AND to_user_id = ? `,
				['read', userId, toUserId]
			);
			// console.log('Query', TESTasd);
			return await this.db.query(
				`SELECT id,from_user_id as fromUserId,to_user_id as toUserId,message,time,date,type,file_format as fileFormat,file_path as filePath FROM messages WHERE
					(from_user_id = ? AND to_user_id = ? )
					OR
					(from_user_id = ? AND to_user_id = ? )	ORDER BY id ASC
				`,
				[userId, toUserId, toUserId, userId]
			);
		} catch (error) {
			console.warn(error);
			return null;
		}
	}

	async mkdirSyncRecursive(directory){
		var dir = directory.replace(/\/$/, '').split('/');
        for (var i = 1; i <= dir.length; i++) {
            var segment = path.basename('uploads') + "/" + dir.slice(0, i).join('/');
            !fs.existsSync(segment) ? fs.mkdirSync(segment) : null ;
        }
	}
}
module.exports = new Helper();
