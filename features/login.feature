Feature: Login and Password Reset
    In order to use the members only features of the site
    As a member
    I need the ability to login and possibly reset my password

    Scenario: Elements on the Login Form
        Given I am on the "login" page
        Then there should be a "form" with "action,method" having values "/login,post"
        And an "input" with "type,name" having values "hidden,_token"
        And an "input" with "type,name,id" having values "text,login,login"
        And an "input" with "type,name,id" having values "password,password,password"
        And a "button" with "type,id" having values "submit,submit"
        And an "a" with "href" having values "/reset"
        And the "a[href*='reset']" element should contain "Reset Password"
        And an "a" with "href" having values "/register"
        And the "a[href*='register']" element should contain "Register"
        And every visible input should have a label

     Scenario: A user is registered
        Given I am on the "register" page
        When I fill in "username" with "jsmith"
        And I fill in "first_name" with "John"
        And I fill in "last_name" with "Smith"
        And I fill in "email" with "john.smith@gmail.com"
        And I fill in "password" with "I am number 1!"
        And I fill in "email_confirmation" with "john.smith@gmail.com"
        And I fill in "password_confirmation" with "I am number 1!"
        And I press "submit"
        Then I should be on "login"
        And an activation email should be sent to "John Smith <john.smith@gmail.com>"

    Scenario: The account is activated
        Given an activation email was sent to "John Smith <john.smith@gmail.com>"
        When I go to the link from the email
        Then I should see "Thank you! Your Portphilio account is now active."

   Scenario: User is notified of login form submission errors
        Given I am on the "login" page
        When I press "submit"
        Then there should be a "div" with the "class" "alert"

    Scenario: All login fields are required
        Given I am on the "login" page
        When I fill in "login" with ""
        And I fill in "password" with ""
        And I press "submit"
        Then I should see "The username/email is required"
        And I should see "The password is required"

    Scenario: Successful login with username
        Given I am on the "login" page
        When I fill in "login" with "jsmith"
        And I fill in "password" with "I am number 1!"
        And I press "submit"
        Then I should be on "dashboard"

    Scenario: Successful login with email
        Given I am on the "login" page
        When I fill in "login" with "john.smith@gmail.com"
        And I fill in "password" with "I am number 1!"
        And I press "submit"
        Then I should be on "dashboard"

    Scenario: Elements on the Reset Form
        Given I am on the "reset" page
        Then there should be a "form" with "action,method" having values "/reset,post"
        And an "input" with "type,name" having values "hidden,_token"
        And an "input" with "type,name,id" having values "text,login,login"
        And a "label" with "for" having values "login"
        And the "label[for*='login']" element should contain "Username or Email"

    Scenario: All reset fields are required
        Given I am on the "reset" page
        When I fill in "login" with ""
        And I press "submit"
        Then I should see "The username/email is required"

    Scenario: Reset is successful using username
        Given I am on the "reset" page
        When I fill in "login" with "jsmith"
        And I press "submit"
        Then I should be on "/login"
        And a reset email should be sent to "John Smith <john.smith@gmail.com>"

    Scenario: Reset is successful using email
        Given I am on the "reset" page
        When I fill in "login" with "john.smith@gmail.com"
        And I press "submit"
        Then I should be on "/login"
        And a reset email should be sent to "John Smith <john.smith@gmail.com>"

    Scenario: Reset fails using wrong/non-existant username
        Given I am on the "reset" page
        When I fill in "login" with "jdoe"
        And I press "submit"
        Then I should be on "/reset"
        And I should see "The username or email you entered was not found."

    Scenario: Reset fails using wrong/non-existant email
        Given I am on the "reset" page
        When I fill in "login" with "jane.smith@gmail.com"
        And I press "submit"
        Then I should be on "/reset"
        And I should see "The username or email you entered was not found."

    Scenario: Incorrect user id
        Given a reset email was sent to "John Smith <john.smith@gmail.com>"
        And I am on "/reset/2/thisisthewrongcode"
        Then I should see "Sorry! We couldn't find an account with that ID"

    Scenario: Incorrect reset code
        Given a reset email was sent to "John Smith <john.smith@gmail.com>"
        And I am on "/reset/1/thisisthewrongcode"
        Then I should see "Ruh-roh! You may have used an invalid reset code. Please double check the link from your reset email and try again."

    Scenario: Elements on the Password Reset Form
        Given I go to the link from the email
        Then there should be a "form" with "action,method" having values "/reset,put"
        And an "input" with "type,name" having values "hidden,_token"
        And an "input" with "type,name" having values "hidden,user_id"
        And an "input" with "type,name" having values "hidden,reset_code"
        And an "input" with "type,name,id" having values "password,password,password"
        And an "input" with "type,name,id" having values "password,password_confirmation,password_confirmation"
        And a "button" with "type,id" having values "submit,submit"
        And an "a" with "href" having values "/login"
        And the "a[href*='login']" element should contain "Login"
        And every visible input should have a label

    Scenario: Password format must be >=11 characters with >=1 upper, lower, digit, and special character
        Given I go to the link from the email
        When I fill in "password" with "i am number 1!"
        And I press "submit"
        Then I should see "The password must be 11 or more characters and have at least one upper, lower, digit, and special character"

    Scenario: Password must be confirmed
        Given I go to the link from the email
        When I fill in "password" with "I am number 2!"
        And I fill in "password_confirmation" with "I am number 3!"
        And I press "submit"
        And I should see "The password confirmation does not match"

   Scenario: Successful password reset
        Given I go to the link from the email
        When I fill in "password" with "I am number 2!"
        And I fill in "password_confirmation" with "I am number 2!"
        And I press "submit"
        Then I should be on "/login"
        And I should see "Your Portphilio password was successfully reset"