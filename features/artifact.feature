Feature: Artifact Management
    In order to have things to put in a portfolio
    As a member
    I need the ability to manage artifacts

    Scenario: Add an Artifact
        Given I am on the "artifacts/create" page
        Then there should be a "form" with "action,method" having values "/artifacts,post"
        And an "input" with "type,name" having values "hidden,_token"
        And a "button" with "type,id" having values "submit,submit"
        And every visible input should have a label
