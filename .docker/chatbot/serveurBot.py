from flask import Flask, request, jsonify # flask est le serveur
from flask_cors import CORS
import ChatBot

app = Flask(__name__)
CORS(app) # Autorise le site web à communiquer avec ce serveur Python

@app.route('/chat', methods=['POST'])
def discuter():
    # On recupére la requete et on la traite
    donnees = request.json
    message_utilisateur = donnees.get("message")
    
    if not message_utilisateur:
        return jsonify({"erreur": "Message vide"}), 400

    # On appelle groq 
    reponse = ChatBot.chatbot_rag(message_utilisateur)
    
    return jsonify({"reponse": reponse})

if __name__ == '__main__':
    print("🎰 Serveur du Croupier Virtuel démarré sur le port 5000 !")
    app.run(port=5000)