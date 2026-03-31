
FROM python:3.11-slim

# 2. On se place dans un dossier de travail à l'intérieur du conteneur
WORKDIR /app


COPY requirements.txt .

#On installe les bibliothèques Python 
RUN pip install --no-cache-dir -r requirements.txt

RUN python -m spacy download fr_core_news_sm

# 6. On copie le reste du code 
COPY . .

CMD ["python", "ChatBot.py"]