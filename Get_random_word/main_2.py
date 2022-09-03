import requests, mariadb
from datetime import date, timedelta

# Get the word

api_url = "https://random-word-api.herokuapp.com/word"
response = requests.get(api_url)
word = response.json()

# Init database conn

conn = mariadb.connect(
    user = "root",
    password = "",
    host = "localhost",
    port = 3306,
    database = "draw_smthg"
)

# Verification

verif = []

sql = "SELECT * FROM word WHERE date = '" + (date.today() + timedelta(days=1)) + "';" 
try:
    cur = conn.cursor(dictionary=True)
    cur.execute(sql)
    verif = cur.fetchall()

except mariadb.Error as e:
    print(f"Error: {e}")

print("word = ", word)

# Insert in database

if (len(verif) == 0):

    sql = "INSERT INTO word (word, date) VALUES ('" + word + "', '" + (date.today() + timedelta(days=1)) + "');"
    print(sql)
    try:
        cur = conn.cursor()
        cur.execute(sql)
        conn.commit()

    except mariadb.Error as e:
        print(f"Error: {e}")

    print("done")