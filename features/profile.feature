Feature: User Profile Page
    In order to keep one's personal information current
    As a member
    I need the ability to view and modify my profile

    Scenario: Elements on the Profile Page
        Given I am on the "users/profile" page
        Then I should see "My Profile"
