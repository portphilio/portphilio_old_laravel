Feature: Registration
    In order to become a member of the site
    As a non-member
    I need the ability to register

    Scenario: Elements on the Registration Form
        Given I am on the "register" page
        Then there should be a "form" with "action,method" having values "/register,post"
        And an "input" with "type,name" having values "hidden,_token"
        And an "input" with "type,name,id" having values "text,username,username"
        And an "input" with "type,name,id" having values "text,first_name,first_name"
        And an "input" with "type,name,id" having values "text,last_name,last_name"
        And an "input" with "type,name,id" having values "email,email,email"
        And an "input" with "type,name,id" having values "email,email_confirmation,email_confirmation"
        And an "input" with "type,name,id" having values "password,password,password"
        And an "input" with "type,name,id" having values "password,password_confirmation,password_confirmation"
        And an "input" with "type,name,id" having values "submit,submit,submit"
        And every visible input should have a label

    Scenario: User is notified of form submission errors
        Given I am on the "register" page
        When I press "submit"
        Then there should be a "div" with the "class" "alert"

    Scenario: All fields are required
        Given I am on the "register" page
        When I fill in "username" with ""
        And I fill in "first_name" with ""
        And I fill in "last_name" with ""
        And I fill in "email" with ""
        And I fill in "password" with ""
        And I press "submit"
        Then I should see "The username field is required"
        And I should see "The first name field is required"
        And I should see "The last name field is required"
        And I should see "The email field is required"
        And I should see "The password field is required"

    Scenario: Username must be at least 3 alphanumeric characters long
        Given I am on the "register" page
        When I fill in "username" with "ab"
        And I press "submit"
        And I should see "The username must be three or more alphanumeric characters long"

    Scenario: Email format must be valid
        Given I am on the "register" page
        When I fill in "email" with "john.smith@gmail"
        And I press "submit"
        Then I should see "The email must be a valid email address"

    Scenario: Password format must be >=11 characters with >=1 upper, lower, digit, and special character
        Given I am on the "register" page
        When I fill in "password" with "i am number 1!"
        And I press "submit"
        Then I should see "The password must be 11 or more characters and have at least one upper, lower, digit, and special character"

    Scenario: Email and Password must be confirmed
        Given I am on the "register" page
        When I fill in "email" with "john.smith@gmail.com"
        And I fill in "email_confirmation" with "johnsmith@gmail.com"
        When I fill in "password" with "I am number 1!"
        And I fill in "password_confirmation" with "I am number 2!"
        And I press "submit"
        Then I should see "The email confirmation does not match"
        And I should see "The password confirmation does not match"

    Scenario: Registration is successful
        Given I am on the "register" page
        When I fill in "username" with "jsmith"
        And I fill in "first_name" with "John"
        And I fill in "last_name" with "Smith"
        And I fill in "email" with "john.smith@gmail.com"
        And I fill in "password" with "I am number 1!"
        And I fill in "email_confirmation" with "john.smith@gmail.com"
        And I fill in "password_confirmation" with "I am number 1!"
        And I press "submit"
        Then I should be on "/"
        And an activation email should be sent to "John Smith <john.smith@gmail.com>"

    Scenario: Username and email are already in use
        Given I am on the "register" page
        When I fill in "username" with "jsmith"
        And I fill in "first_name" with "John"
        And I fill in "last_name" with "Smith"
        And I fill in "email" with "john.smith@gmail.com"
        And I fill in "password" with "I am number 1!"
        And I fill in "email_confirmation" with "john.smith@gmail.com"
        And I fill in "password_confirmation" with "I am number 1!"
        And I press "submit"
        Then I should be on "/register"
        And I should see "The email has already been taken"
        And I should see "The username has already been taken"

    Scenario: Incorrect activation code
        Given an activation email was sent to "John Smith <john.smith@gmail.com>"
        And I am on "/activate/1/thisisthewrongcode"
        Then I should see "Ruh-roh! You may have used an invalid activation code. Please double check the link from your activation and try again."

    Scenario: Account activation
        Given an activation email was sent to "John Smith <john.smith@gmail.com>"
        When I go to the activation link
        Then I should see "Thank you! Your Portphilio account is now active."

    Scenario: Account duplicate activation
        Given an activation email was sent to "John Smith <john.smith@gmail.com>"
        When I go to the activation link
        And I go to the activation link
        Then I should see "Your account was already activated."

    Scenario: Attempt to activate an unknown/missing/deleted account
        Given I am on "/activate/2/unknown"
        Then I should see "Sorry! We couldn't find an account with that ID"

    Scenario: Activation code is expired
        Given an activation email was sent to "John Smith <john.smith@gmail.com>"
        And the activation has expired
        When I go to the activation link
        Then I should see "This activation code expired."
