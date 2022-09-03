from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

import random, mariadb
from datetime import date

# Init browser

driver = webdriver.Firefox()
driver.get("https://randomwordgenerator.com/pictionary.php")

# website consent 

wait = WebDriverWait(driver, 10)
try:
    element = wait.until(EC.element_to_be_clickable((By.CLASS_NAME, "fc-button-label")))
    reset = driver.find_element(By.CLASS_NAME, "fc-button-label").click()
except Exception as e:
    print(f"Error: {e}")

# Select random difficulty

select = Select(driver.find_element(By.ID, "category"))
list = ["Easy", "Medium", "Hard", "Really Hard"]
select.select_by_visible_text(random.choice(list))

# Get the word

generate_button = driver.find_element(By.ID, "btn_submit_generator").click()
word = driver.find_element(By.CLASS_NAME, "support-sentence").text
print(word)

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

sql = "SELECT * FROM word WHERE date = '" + date.today().isoformat() + "';" 
try:
    cur = conn.cursor(dictionary=True)
    cur.execute(sql)
    verif = cur.fetchall()

except mariadb.Error as e:
    print(f"Error: {e}")

print("word = ", word)

# Insert in database

if (len(verif) == 0):

    sql = "INSERT INTO word (word, date) VALUES ('" + word + "', '" + date.today().isoformat() + "');"
    print(sql)
    try:
        cur = conn.cursor()
        cur.execute(sql)
        conn.commit()

    except mariadb.Error as e:
        print(f"Error: {e}")

    print("done")