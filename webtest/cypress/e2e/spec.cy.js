describe('localhost:8000', () => {
  it('localhost:8000', () => {
    cy.visit('localhost:8000')
    cy.wait(500)

    //login
    cy.contains('Bejelentkezés').click()
    cy.wait(500)
    cy.get('input[name=log_username]').type('admin')
    cy.get('input[name=log_password]').type('admin')
    cy.contains('Belépés').click()
    cy.wait(500)
    cy.contains('Kijelentkezés').click()
    cy.wait(500)
    cy.contains('Bejelentkezés').click()
    cy.wait(500)
    cy.get('input[name=log_username]').type('test')
    cy.get('input[name=log_password]').type('test1234567')
    cy.contains('Belépés').click()

    //új témakör megválaszolása
    cy.wait(500)
    cy.contains('Témakörök').click()
    cy.contains('Új témakör megválaszolása').click()
    cy.wait(500)
    cy.contains('Teszt')
    cy.get('button[name=selected]').click()
    cy.contains('4').click()
    cy.contains('Válaszok beküldése').click()
    cy.wait(500)
    cy.contains('Nincs rekord')

    //kitöltött témakör kitörlése
    cy.wait(500)
    cy.contains('Témakörök').click()
    cy.contains('Kitöltött kérdőívek megjelenítése').click()
    cy.wait(500)
    cy.contains('Teszt')
    cy.contains('Összes válasz törlése').click()
    cy.wait(500)
    cy.contains('Nincs rekord')


    //átlagok
    cy.wait(500)
    cy.contains('Témakörök').click()
    cy.contains('Átlagok').click()
    cy.wait(500)
    cy.contains('Teszt')
    cy.contains('1')


    //statisztika
    cy.wait(500)
    cy.contains('Témakörök').click()
    cy.contains('Statisztika').click()
    cy.wait(500)
    cy.contains('2')
    cy.contains('0')

    //adataim
    cy.wait(500)
    cy.contains('Adataim').click()
    cy.wait(500)
    cy.get('input[value=test]')

    //kezdőlap
    cy.wait(500)
    cy.contains('Kezdőlap').click()
    cy.wait(500)
    cy.contains('Üdvözöllek a kérdőív oldalon!')

    //admin
    cy.contains('Kijelentkezés').click()
    cy.wait(500)
    cy.contains('Bejelentkezés').click()
    cy.wait(500)
    cy.get('input[name=log_username]').type('admin')
    cy.get('input[name=log_password]').type('admin')
    cy.contains('Belépés').click()

    //admin panel
    cy.contains('Admin').click()
    cy.contains('Felhasználók szerkesztése').click()
    cy.wait(500)
    cy.contains('test@test.com')
    cy.contains('User')
    cy.contains('Promote to Admin').click()
    cy.wait(500)
    cy.contains('Admin')
    cy.contains('Revoke').click()
    cy.wait(500)
    cy.contains('User')
    cy.contains('Kijelentkezés').click()
  })
})