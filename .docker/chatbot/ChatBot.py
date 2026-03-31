# =============================================================
# CHATBOT CASINO ROYAL - NIVEAU 3 : RAG + API Groq (llama)
#pip install groq
# =============================================================

import json
import os
import spacy
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from groq import Groq
import numpy as np

# -------------------------------------------------------------
# CONFIGURATION 
# -------------------------------------------------------------
API_KEY = "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"
client = Groq(api_key=API_KEY)

# -------------------------------------------------------------
# ETAPE 1 — Chargement spaCy + données du Casino
# -------------------------------------------------------------
nlp = spacy.load("fr_core_news_sm")

# On charge le nouveau fichier JSON
with open("bibliotheque.json", "r", encoding="utf-8") as f:
    casino_data = json.load(f)

# -------------------------------------------------------------
# ETAPE 2 — Lemmatisation
# -------------------------------------------------------------
def lemmatiser(texte):
    doc = nlp(texte.lower())
    lemmes = [token.lemma_ for token in doc
              if not token.is_stop and not token.is_punct]
    return " ".join(lemmes)

# -------------------------------------------------------------
# ETAPE 3 — Construction de la matrice TF-IDF 
# -------------------------------------------------------------
def construire_description(jeu):
    # On concatène les infos du jeu pour la recherche
    return (
        f"{jeu['Nom du jeu']} "
        f"{jeu['Type']} "
        f"{jeu['Règles']} "
        f"{jeu['Gains']}"
    )

descriptions = [lemmatiser(construire_description(j)) for j in casino_data]
vectoriseur = TfidfVectorizer()
matrice_tfidf = vectoriseur.fit_transform(descriptions)

# -------------------------------------------------------------
# ETAPE 4 — Retrieval : récupérer les jeux les plus pertinents
# -------------------------------------------------------------
def recuperer_jeux_pertinents(requete, top_n=2):
    """
    Retourne les top_n jeux les plus pertinents pour la requête.
    """
    requete_lemmatisee = lemmatiser(requete)
    vecteur = vectoriseur.transform([requete_lemmatisee])
    similarites = cosine_similarity(vecteur, matrice_tfidf).flatten()
    indices_tries = np.argsort(similarites)[::-1]

    jeux_pertinents = []
    for i in indices_tries[:top_n]:
        if similarites[i] > 0.0:
            jeux_pertinents.append(casino_data[i])

    return jeux_pertinents

# -------------------------------------------------------------
# ETAPE 5 — Construction du Contexte pour GPT
# -------------------------------------------------------------
def construire_contexte(jeux):
    if not jeux:
        return "Aucun jeu spécifique trouvé correspondant à la demande."

    contexte = "Voici les informations sur les jeux du casino :\n\n"
    for i, jeu in enumerate(jeux, 1):
        contexte += f"Jeu {i} :\n"
        contexte += f"  - Nom          : {jeu['Nom du jeu']}\n"
        contexte += f"  - Type         : {jeu['Type']}\n"
        contexte += f"  - Mise minimum : {jeu['Mise minimum']}\n"
        contexte += f"  - Règles       : {jeu['Règles']}\n"
        contexte += f"  - Gains        : {jeu['Gains']}\n\n"
    return contexte

# -------------------------------------------------------------
# ETAPE 6 — Prompt Système (Le rôle du Croupier)
# -------------------------------------------------------------
SYSTEM_PROMPT = """
Tu es l'hôte virtuel officiel et le croupier en chef du 'Casino Royal'.
Tu accueilles les joueurs avec élégance, politesse et une touche de mystère.
Tu les aides à comprendre les règles des jeux proposés dans l'établissement.

Règles strictes :
1. Tu réponds UNIQUEMENT en te basant sur le contexte des jeux fourni.
2. Si on te pose une question sur un jeu qui n'est pas dans le Casino Royal (ex: Poker, Roulette), tu expliques courtoisement que ce jeu n'est pas encore disponible dans nos salons actuels.
3. Ne donne jamais de conseils financiers réels, rappelle que le jeu doit rester un divertissement.
4. N'invente jamais de multiplicateurs ou de règles qui ne sont pas dans le contexte.
5. Utilise un vocabulaire de casino élégant (jetons, mise, croupier, salon, chance).
"""

# -------------------------------------------------------------
# ETAPE 7 — Historique de conversation
# -------------------------------------------------------------
historique = [
    {"role": "system", "content": SYSTEM_PROMPT}
]

# -------------------------------------------------------------
# ETAPE 8 — Appel à l'API OpenAI
# -------------------------------------------------------------
def appeler_gpt(requete_utilisateur, contexte_jeux):
    message_augmente = f"""
Question du joueur : {requete_utilisateur}

{contexte_jeux}

Réponds à la question en te basant uniquement sur les jeux ci-dessus.
"""
    historique.append({"role": "user", "content": message_augmente})

    reponse = client.chat.completions.create(
        model="llama-3.1-8b-instant",
        messages=historique,
        temperature=0.5, # Légèrement plus créatif pour le roleplay du croupier
        max_tokens=400
    )

    texte_reponse = reponse.choices[0].message.content
    historique.append({"role": "assistant", "content": texte_reponse})

    return texte_reponse

# -------------------------------------------------------------
# ETAPE 9 — Fonction principale
# -------------------------------------------------------------
def chatbot_rag(requete):
    jeux_pertinents = recuperer_jeux_pertinents(requete, top_n=2)
    contexte = construire_contexte(jeux_pertinents)
    reponse = appeler_gpt(requete, contexte)
    return reponse

"""
# MAIN — Boucle de dialogue
print("=" * 60)
print("  🎰 ChatBot Casino Royal - Service d'assistance")
print("=" * 60)
print("Exemples de questions :")
print("  → Comment fonctionne la machine à sous ?")
print("  → Si je joue au pile ou face, combien je peux gagner ?")
print("  → Quelles sont les règles du Bingo ?")
print()

while True:
    print("Tapez 'quitter' pour sortir du salon")
    req = input("Vous > ").strip()

    if req.lower() == "quitter":
        print("Le Casino Royal vous souhaite une excellente journée. À bientôt !")
        break
    elif req == "":
        continue
    else:
        reponse = chatbot_rag(req)
        print(f"\n🎩 Hôte du Casino > {reponse}\n")
        print("-" * 60)
"""