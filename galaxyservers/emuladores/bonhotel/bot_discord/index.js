const Discord = require("discord.js");
const client = new Discord.Client();
const config = require("./config.json");
const atividade_db = require("./database/atividade.json");
var mysql = require('mysql');

client.on("ready", () => {
	console.log(`O bot foi iniciado! servindo a ${client.users.size} usuários, ${client.channels.size} canais e ${client.guilds.size} servidores.`);
	client.user.setActivity(atividade_db.atividade_texto, { type: atividade_db.atividade_status, url: 'http://twitch.tv/#' });
});

/// Faz a conexão MySQL
console.log("Conectando ao servidor MySQL...");
var con = mysql.createConnection({
	host: config.hostmysql,
	user: config.usermysql,
	password: config.passmysql,
	database : config.dbmysql
});
setInterval(function () {
	con.query('SELECT 1');
}, 5000);
con.connect(function(error) {
	if (error) throw error;
	console.log("Conectado ao servidor MySQL!");
	con.query("SELECT COUNT(id) as totalusers, (SELECT count(id) FROM cms_news) as totalnoticias, (SELECT count(id) FROM users WHERE online = '1') as totalons FROM users;", function (err, result) {
		if (err) throw err;
		console.log("[Informações do Hotel] Total de usuários: " + result[0]['totalusers'] + " / Usuários onlines: " + result[0]['totalons'] + " / Total de notícias: " + result[0]['totalnoticias']);
	});
});
/// Fim conexão MySQL

/// Mensagens de bem vindo/adeus
if(config.mensagensentradaesaida == "ativado"){
	client.on('guildMemberAdd', member => {
		const channel = member.guild.channels.find(ch => ch.id === config.idcanalbemvindos);
		if (!channel) return;
		channel.send(`${member} entrou no servidor!`);
	});
	client.on('guildMemberRemove', member => {
		const channel = member.guild.channels.find(ch => ch.id === config.idcanaladeus);
		if (!channel) return;
		channel.send(`${member} saiu do servidor!`);
	});
}
/// Fim das mensagens de bem vindo/adeus

client.on("message", async message => {

/// Atualiza status do servidor
if(config.status_canal == "ativado"){
	con.query("SELECT count(id) as onlines,(SELECT count(id) FROM users) as registrados,(SELECT count(id) FROM cms_news) as noticias FROM users WHERE online = '1';", function (err, result) {
		if (err) throw err;
		client.channels.get(config.canal_userson).setName(`Usuários onlines: ${result[0]['onlines']}`);﻿
		client.channels.get(config.canal_usersregistrados).setName(`Usuários registrados: ${result[0]['registrados']}`);﻿
		client.channels.get(config.canal_userNoServidor).setName(`Notícias postadas: ${result[0]['noticias']}`);﻿
	});
}
/// Fim do sistema de atualização.

if (message.author.bot) return; // Se for uma mensagem enviada por BOT ele retorna.

/// Sistema de proibição de links e convites de servidores
if(message.content.toLowerCase().match('discord.gg') && !message.member.hasPermission("ADMINISTRATOR")){
	message.delete();
	message.channel.send(`${message.author}, você não pode enviar convites de outros servidores aqui!`);
} else if((message.content.toLowerCase().match('www.') || message.content.toLowerCase().match('http://') || message.content.toLowerCase().match('https://')) && !message.member.hasPermission("ADMINISTRATOR")){
	message.delete();
	message.channel.send(`${message.author}, você não pode enviar links aqui!`);
}
/// Fim do sistema de proibição de links e convites de servidores

/// Verificação do usuário
if(config.verificacao == "ativado"){
	if(message.channel.id == config.idcanalverificacao){
		var stringmsg = message.content;
		if(stringmsg.toLowerCase() == "verificado") return;
		if(stringmsg != ""){
			con.query("SELECT username FROM users WHERE verifica_discord = ? LIMIT 1;",[stringmsg], function (err, result) {
				if (err) throw err;
				try{
					if(result[0]['username'] != ""){
                message.guild.member(message.author).setNickname(result[0]['username']); /// Faz alterações do apelido
                message.member.addRole(message.guild.roles.find('name', config.nomecargoverificados)); /// Faz alterações do rank
                con.query("UPDATE users SET verifica_discord = 'VERIFICADO' WHERE verifica_discord = ? LIMIT 1;",[stringmsg], function (err, result) {
                	if (err) throw err;
                });
                message.delete().catch(O_o => { });
                message.channel.send(`O usuário ${message.author} verificou sua conta com sucesso!`);
            } 
        } catch (erro) {
        	message.delete().catch(O_o => { });
        	message.channel.send(`${message.author} esta chave é inválida!`);
        }});
		}
	}
}

if (message.content.indexOf(config.prefix) !== 0) return;
const args = message.content.slice(config.prefix.length).trim().split(/ +/g);
const command = args.shift().toLowerCase();
var prefixobot = config.prefix;

if (command == `-;` || command == `-:` || command == "") return;

if(message.guild == null) return;

/// Daqui para baixo é só comandos...
if (command === "ping") {
	const m = await message.channel.send("Ping?");
	m.edit(`Pong ${message.author} :ping_pong:! Latência de ${m.createdTimestamp - message.createdTimestamp}ms. Latência da API de ${Math.round(client.ping)}ms`);
}
else if (command === "say") {
	const sayMessage = args.join(" ");
	message.delete().catch(O_o => { });
	if (sayMessage == "" || sayMessage == " ")
		return message.channel.send(`${message.author}, você não pode enviar um say vazio.`);
	message.channel.send(sayMessage);
}
else if (command === "kick") {
	if (!message.member.hasPermission("ADMINISTRATOR"))
		return message.channel.send("Você não pode utilizar esse comando!");
	let member = message.mentions.members.first() || message.guild.members.get(args[0]);
	if (!member)
		return message.reply("Por favor mencione um membro válido deste servidor!");
	if (!member.kickable)
		return message.reply("Você não pode kikar esse usuário!");
	let reason = args.slice(1).join(' ');
	if (!reason) reason = "Nenhuma rasão encontrada";
	await member.kick(reason)
	.catch(error => message.reply(`Desculpe ${message.author} você não pode expulsar! ${error}`));
	message.reply(`${member.user.tag} foi kikado por ${message.author.tag}! motivo: ${reason}`);
}
else if (command === "ban") {
	if (!message.member.hasPermission("ADMINISTRATOR"))
		return message.channel.send("Você não pode utilizar esse comando!");
	let member = message.mentions.members.first();
	if (!member)
		return message.reply("Por favor mencione um membro válido deste servidor!");
	if (!member.bannable)
		return message.reply("Eu não posso banir este usuário! Eles têm um papel maior? Eu tenho permissões de proibição?");
	let reason = args.slice(1).join(' ');
	if (!reason) reason = "Nenhum motivo especificado";
	await member.ban(reason)
	.catch(error => message.reply(`Desculpe ${message.author} você não pode banir esse usuário, erro: ${error}`));
	message.reply(`${member.user.tag} baniu o usuário ${message.author.tag} pelo motivo: ${reason}`);
}
else if (command === "onlines") {
	const m = await message.channel.send("Estou contando os usuários onlines...");
	con.query("SELECT count(id) as userson FROM users WHERE online = '1';", function (err, result) {
		if (err) throw err;
		m.edit(`${message.author}, temos ${result[0]['userson']} usuários onlines!`);
	});
}
else if (command === "totalnoticias") {
	const m = await message.channel.send("Estou contando as notícias...");
	con.query("SELECT count(id) as totalnoticias FROM cms_news;", function (err, result) {
		if (err) throw err;
		m.edit(`${message.author}, temos ${result[0]['totalnoticias']} notícias postadas!`);
	});
}
else if (command === "totalusuarios") {
	const m = await message.channel.send("Estou contando os usuários...");
	con.query("SELECT count(id) as totalusuarios FROM users;", function (err, result) {
		if (err) throw err;
		m.edit(`${message.author}, temos ${result[0]['totalusuarios']} usuários registrados!`);
	});
}
else if (command === "ultimanoticia") {
	con.query("SELECT * FROM cms_news ORDER BY id DESC LIMIT 1;", function (err, result) {
		if (err) throw err;
		const embed = {
			"description": `Clique [aqui](${config.linkhotel_news+result[0]['id']}) para ver no hotel.`,
			"color": config.corembed,
			"footer": {
				"icon_url": config.icone_embed,
				"text": `${config.nomehotel} BOT ${config.versao}`
			},
			"fields": [
			{
				"name": result[0]['title'],
				"value": result[0]['shortstory']
			}]
		};
		message.channel.send({embed});
	});
}
else if (command === "help" || command === "comandos" || command === "commands") {
	const embed = {
		"description": `Olá ${message.author}, eu sou um bot oficial do ${config.nomehotel} Hotel! Veja abaixo meus comandos!`,
		"color": config.corembed,
		"footer": {
			"icon_url": config.icone_embed,
			"text": `${config.nomehotel} BOT ${config.versao}`
		},
		"fields": [
		{
			"name": `${prefixobot}ping`,
			"value": "Faz um teste de latência e exibe em milisegundos o tempo demorado."
		},
		{
			"name": `${prefixobot}say %palavra%`,
			"value": "Faz o bot dizer a palavra enviada após o comando."
		},
		{
			"name": `${prefixobot}onlines`,
			"value": "Exibe a quantidade de usuários onlines no hotel."
		},
		{
			"name": `${prefixobot}ultimanoticia`,
			"value": "Exibe a última notícia postada no hotel."
		},
		{
			"name": `${prefixobot}totalnoticias`,
			"value": "Exibe a quantidade de notícias postadas no hotel."
		},
		{
			"name": `${prefixobot}totalusuarios `,
			"value": "Exibe a quantidade de usuários registrados no hotel."
		},
		{
			"name": `${prefixobot}comandos`,
			"value": "Exibe os comandos disponíveis do BOT."
		},
		{
			"name": `${prefixobot}roleta`,
			"value": "Saiba se você morreu ou viveu com a roleta russa."
		},
		{
			"name": `${prefixobot}avatar %usuario%`,
			"value": "Faz o bot mandar a imagem do perfil do usuário."
		},
		{
			"name": `${prefixobot}gif %pesquisa%`,
			"value": "Faz o bot mandar um gif aleatório com base na pesquisa."
		},
		{
			"name": `${prefixobot}ship %user% %user%`,
			"value": "Vê as possibilidades do casal dar certo."
		},
		{
			"name": `${prefixobot}poll`,
			"value": "Inicia uma votação."
		},
		{
			"name": `${prefixobot}cuckmeter`,
			"value": "Veja o quanto você é corno."
		}
		]
	};
	message.channel.send({ embed });

	if (message.member.hasPermission("ADMINISTRATOR")){
		const embed = {
			"description": `Comandos Administrativos:`,
			"color": config.corembed,
			"footer": {
				"icon_url": config.icone_embed,
				"text": `${config.nomehotel} BOT ${config.versao}`
			},
			"fields": [
			{
				"name": `${prefixobot}infosistema`,
				"value": "Exibe informações do sistema."
			},
			{
				"name": `${prefixobot}kick %usuario% %motivo%`,
				"value": "Expulsa o usuário do servidor."
			},
			{
				"name": `${prefixobot}ban %usuario% %motivo% `,
				"value": "Bane o usuário do servidor."
			},
			{
				"name": `${prefixobot}mudastatus %idle/dnd/online/invisible%`,
				"value": "Muda o status do BOT."
			},
			{
				"name": `${prefixobot}limparchat`,
				"value": "Apaga as conversas do canal."
			},
			{
				"name": `${prefixobot}atividade %tipo% %atividade% `,
				"value": "Muda a atividade do bot."
			},
			{
				"name": `${prefixobot}flood`,
				"value": "Envia mensagem no privado de todos os usuários do canal."
			},

			]
		};
		message.channel.send({ embed }); 

	}
}
else if (command === "uptime") {
	let totalSeconds = (client.uptime / 1000);
	let hours = Math.floor(totalSeconds / 3600);
	totalSeconds %= 3600;
	let minutes = Math.floor(totalSeconds / 60);
	let uptime = `Olá ${message.author}, eu estou online há ${hours} horas e ${minutes} minutos.`;
	message.channel.send(uptime);
}
else if(command === "roleta") {
	function getRandomInt(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}
	var numero = getRandomInt(1, 6);
	if (numero == 3 || numero == 6)
		message.channel.send(`Morreu! :weary:`);
	else
		message.channel.send(`Sobreviveu!`);
}
else if (command === "convite") {
	const embed = {
		"description": `Convide seus amigos para entrar no nosso servidor!`,
		"color": config.corembed,
		"footer": {
			"icon_url": config.icone_embed,
			"text": `${config.nomehotel} BOT ${config.versao}`
		},
		"fields": [
		{
			"name": `${config.linkdiscord}`,
			"value": "Basta compartilhar o link acima!"
		},
		]
	};
	message.channel.send({ embed });    
	message.author.send({ embed }); 
}
else if (command === "avatar") {
	let msg = await message.channel.send("Carregando imagem...");
	let target = message.mentions.users.first() || message.author;
	await message.channel.send({
		files: [
		{
			attachment: target.displayAvatarURL,
			name: "Imagem de " + target.username + ".png"
		}
		]
	});
	msg.delete();
}
else if (command == "gif") {
	function removeAcento(text) {
		text = text.toLowerCase();
		text = text.replace(new RegExp('[ÁÀÂÃ]', 'gi'), 'a');
		text = text.replace(new RegExp('[ÉÈÊ]', 'gi'), 'e');
		text = text.replace(new RegExp('[ÍÌÎ]', 'gi'), 'i');
		text = text.replace(new RegExp('[ÓÒÔÕ]', 'gi'), 'o');
		text = text.replace(new RegExp('[ÚÙÛ]', 'gi'), 'u');
		text = text.replace(new RegExp('[Ç]', 'gi'), 'c');
		return text;
	}
	const tagpesquisa = removeAcento(args.join(" "));
	const m = await message.channel.send("Carregando GIF...");
	const https = require('http');
	https.get('http://api.giphy.com/v1/gifs/random?api_key=2XuizEXFX6Iw1UQrwYFyY94lAaueloco&tag=' + tagpesquisa + '&limit=1', (resp) => {
		let data = '';
		resp.on('data', (chunk) => {
			data += chunk;
		});
		resp.on('end', () => {
			obj = JSON.parse(data);
			message.channel.send({
				files: [
				{
					attachment: "https://media.giphy.com/media/" + obj.data.id + "/giphy.gif",
					name: "giphy.gif"
				}
				]
			});
			m.delete();
		});
	}).on("error", (err) => {
		console.log("Error: " + err.message);
		m.edit(`${message.author}, tivemos um erro ao executar o comando...`);
	});
}
else if (command == "ship") {
	var Jimp = require('jimp');
	let porcentagem = Math.floor((Math.random() * 100) + 1);
	let mUser = message.mentions.users.first();
	let mUser2 = message.mentions.users.last();

	if (!mUser || !mUser2 || !mUser && !mUser2 || mUser == mUser2) return message.channel.send(`Não, não! Você está utilizando do jeito errado =( Tente: 'ship @user1 @user2)`)
		const m = await message.channel.send("Calculando o ship...");
	const user1avatarimage = mUser.avatarURL;
	const user2avatarimage = mUser2.avatarURL;

	if (user1avatarimage == "undefinied" || user2avatarimage == "undefinied" || user1avatarimage == null || user2avatarimage == null)
		var imagem = false;
	else
		var imagem = true;

	var imagetobase = config.imagem_ship;

	const embed = {
		"color": config.corembed,
		"footer": {
			"icon_url": config.icone_embed,
			"text": `${config.nomehotel} BOT ${config.versao}`
		},
		"fields": [
		{
			"name": "Compatibilidade: " + `${porcentagem}%`,
			"value": "\u200b"
		},
		{
			"name": `${mUser.username}#${mUser.discriminator}`,
			"value": "Usuário 1",
			"inline": true
		},
		{
			"name": `${mUser2.username}#${mUser2.discriminator}`,
			"value": "Usuário 2",
			"inline": true
		}
		]
	};
	if (imagem) {
		try {
			Jimp.read(user1avatarimage, function (err, imagetouse) {
				imagetouse.quality(60)
				.resize(220, 220)
				.write("./imagem/imguser1.jpg");
				Jimp.read(user2avatarimage, function (err, imagetouse2) {
					imagetouse2.quality(60)
					.resize(220, 220)
					.write("./imagem/imguser2.jpg");
					Jimp.read(imagetobase, function (err, mydude) {
						try {
							mydude.composite(imagetouse, 205, 210)
							mydude.composite(imagetouse2, 580, 210)
							mydude.write("./imagem/ship.jpg")
							mydude.getBuffer(`image/jpeg`, (err, buf) => {
								m.delete();
								message.channel.send("", { embed });
								message.channel.send({ files: [{ attachment: buf, name: `./imagem/ship.jpg` }] })
							})
						} catch (erro) {
							console.log(erro);
						}
					})
				}
				)
			})
		} catch (erro) {
			console.log('Erro ao gerar imagem do ship. ' + erro);
		}
	} else {
		m.delete();
		message.channel.send("", { embed });
	}
}
else if (command == "mudastatus") {
	if (!message.member.hasPermission("ADMINISTRATOR"))
		return message.channel.send("Você não pode utilizar esse comando!");
	const estadoenviado = args.join(" ");
	const m = await message.channel.send("Por favor aguarde...");
	if (estadoenviado != "dnd" && estadoenviado != "idle" && estadoenviado != "online" && estadoenviado != "invisible") {
		m.edit(`${message.author}, você não inseriu um estado válido! (dnd, idle, online ou invisible).`);
	} else {
		client.user.setStatus(estadoenviado);
		m.edit(`${message.author}, o estado do bot foi alterado para ${estadoenviado}`);
	}
}
else if (command === "infosistema") {
	if (!message.member.hasPermission("ADMINISTRATOR"))
		return message.channel.send("Você não pode utilizar esse comando!");
	const { version } = require("discord.js");
	const moment = require("moment");
	let os = require('os');
	let cpuStat = require("cpu-stat");
	const _ = require('lodash');
	cpuStat.usagePercent(function (err, percent, seconds) {
		function uptime() {
			let message = '';
			const totalSeconds = process.uptime();
			const days = Math.floor((totalSeconds % 31536000) / 86400);
			const hours = _.parseInt(totalSeconds / 3600) % 24;
			const minutes = _.parseInt(totalSeconds / 60) % 60;
			const seconds = Math.floor(totalSeconds % 60);
			message += days >= 1 ? `${days} dias, ` : '';
			message += hours < 10 ? `${hours} horas, ` : `${hours} horas, `;
			message += minutes < 10 ? `${minutes} min, ` : `${minutes} min, `;
			message += seconds < 10 ? `${seconds} seg.` : `${seconds} seg.`;
			return message;
		}
		function bytesToSize(bytes) {
			var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
			if (bytes == 0) return '0 Byte';
			var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
			return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
		};
		const embed = {
			"title": "Status de nosso servidor!",
			"color": config.corembed,
			"footer": {
				"icon_url": config.icone_embed,
				"text": `${config.nomehotel} BOT ${config.versao}`
			},
			"fields": [
			{
				"name": "• Uso de RAM",
				"value": `${bytesToSize((process.memoryUsage().heapUsed).toFixed(2))} de ${bytesToSize((os.totalmem()).toFixed(2))}`,
				"inline": true
			},
			{
				"name": "• Uso de CPU",
				"value": `${percent.toFixed(2)}%`,
				"inline": true
			},
			{
				"name": "• Arquitetura",
				"value": os.arch(),
				"inline": true
			},
			{
				"name": "• Usuários",
				"value": client.users.size.toLocaleString(),
				"inline": true
			},
			{
				"name": "• Servidores",
				"value": client.guilds.size.toLocaleString(),
				"inline": true
			},
			{
				"name": "• Canais",
				"value": client.channels.size.toLocaleString(),
				"inline": true
			}
			]
		};
		message.channel.send({ embed });
	});
}
else if (command === "poll") {
	const Questao = args.join(" ");
	const embed = {
		"description": Questao,
		"color": config.corembed,
		"footer": {
			"icon_url": config.icone_embed,
			"text": `${config.nomehotel} BOT ${config.versao}`
		},
		"fields": [
		{
			"name": `Reaja para votar`,
			"value": `Votação iniciada por ${message.author.username}#${message.author.discriminator}.`
		},
		]
	};
	let msg = await message.channel.send({ embed: embed });
	message.delete().catch(O_o => { });
	await msg.react('👍');
	await msg.react('❤');
	await msg.react('😆');
	await msg.react('😯');
	await msg.react('😥');
	await msg.react('😡');
}
else if (command === "limparchat") {
	if (!message.member.hasPermission("ADMINISTRATOR"))
		return message.channel.send("Você não pode utilizar esse comando!");
	let deleteStuff = () => {
		let count = 0;
		message.channel.fetchMessages({ limit: 100 })
		.then(messages => {
			let messagesArr = messages.array();
			let messageCount = messagesArr.length;

			for (let i = 0; i < messageCount; i++) {
				messagesArr[i].delete()
				.then(function () {
					count = count + 1;
					if (count >= 100) {
						deleteStuff();
					}
				})
				.catch(function () {
					count = count + 1;
					if (count >= 100) {
						deleteStuff();
					}
				})
			}
		})
		.catch(function (err) {
			console.log('error thrown');
			console.log(err);
		});
	};
	deleteStuff();
}
else if (command === "cuckmeter") {
	if (message.author.username == "PHB")
		return message.channel.send(`${message.author}, você não é corno, você é lindo!`);
	function getRandomInt(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}
	var numero = getRandomInt(0, 100);
	message.channel.send(`${message.author}, você é ${numero}% corno.`);
}
else if (command === "atividade") {
	if (!message.member.hasPermission("ADMINISTRATOR"))
		return message.channel.send("Você não pode utilizar esse comando!");
	var tipo = args[0];
	if (tipo == 'jogando')
		tipo = 'playing';
	if (tipo == 'assistindo')
		tipo = 'watching';
	if (tipo == 'transmitindo')
		tipo = 'streaming';
	if (tipo != 'playing' && tipo != 'watching' && tipo != 'streaming')
		return message.channel.send(`${message.author}, você não digitou uma opção válida! (jogando, assistindo, transmitindo).`);
	var i = 1;
	var string = '';
	while (args[i]) {
		string += args[i] + ' ';
		i++;
	}
	var fs = require('fs');
	fs.writeFile('./database/atividade.json', `{"atividade_status":"${tipo}","atividade_texto":"${string}"}`, function(erro) {
		if(erro) {throw erro;}
	}); 
	client.user.setActivity(string, { type: tipo, url: 'http://twitch.tv/#' });
	message.channel.send(`${message.author}, a atividade do bot alterada para ${args[0].toLowerCase()} ${string}.`);
}
else if (command === "flood") {
	if (!message.member.hasPermission("ADMINISTRATOR"))
		return message.channel.send("Você não pode utilizar esse comando!");
	message.channel.send(`${message.author}, o flood iniciou, por favor aguarde...`);
	message.channel.members.forEach(member => flood_phb(member)); 
	function flood_phb(member){
		try{
			member.send(message.content.replace(`${prefixobot}flood`, ''));
		} catch (erro) {}
	}
}
else {
	message.channel.send(`${message.author}, você não digitou um comando válido! use ${prefixobot}help`);
}
});
client.login(config.token);