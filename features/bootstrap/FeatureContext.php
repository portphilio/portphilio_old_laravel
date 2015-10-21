<?php

use Behat\Behat\Context\Context;
use Laracasts\Behat\Context\Migrator;
use PHPUnit_Framework_Assert as PHPUnit;
use Behat\MinkExtension\Context\MinkContext;
use Laracasts\Behat\Context\Services\MailTrap;
use Behat\Behat\Context\SnippetAcceptingContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
    use Migrator, MailTrap;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I am on the :url page
     */
    public function iAmOnThePage($url)
    {
        $this->visitPath($url);
    }

    /**
     * @Then there should be an :element with the :attribute :value
     * @Then there should be a :element with the :attribute :value
     */
    public function thereShouldBeAnWithThe($element, $attribute, $value)
    {
        $this->assertSession()->elementExists('css', $element.'['.$attribute."~='".$value."']");
    }

    /**
     * @Then /^(?:there should be )?an? "(?P<element>[^"]*)" with(?: attributes)? "(?P<atts>[^"]*)" having values "(?P<vals>[^"]*)"$/
     */
    public function thereShouldBeAnElementWithAttributesHavingValues($element, $atts, $vals)
    {
        $selector = $element;
        $atts = explode(',', $atts);
        $vals = explode(',', $vals);
        for ($i = 0; $i < count($atts); ++$i) {
            $selector .= '['.$atts[$i].'="'.$vals[$i].'"]';
        }
        $this->assertSession()->elementExists('css', $selector);
    }

    /**
     * @Then every visible input should have a label
     */
    public function everyVisibleInputShouldHaveALabel()
    {
        $selector = 'select,textarea,input:not([type="hidden"]):not([type="submit"]):not([type="checkbox"]):not([type="radio"])';
        $fields = $this->getSession()->getPage()->findAll('css', $selector);
        foreach ($fields as $f) {
            $this->assertSession()->elementExists('css', 'label[for="'.$f->getAttribute('id').'"]');
        }
        echo 'APP_ENV='.env('APP_ENV'."\n");
    }

    /**
     * @Then an activation email should be sent to :email
     * @Given an activation email was sent to :email
     */
    public function anActivationEmailShouldBeSentTo($email)
    {
        $msg = $this->fetchInbox()[0];
        preg_match('/(.*?)<(.*?)>/', $email, $matches);
        $to_name = trim($matches[1]);
        $to_email = $matches[2];
        PHPUnit::assertEquals('Welcome to Portphilio! Activate your account...', $msg['subject']);
        PHPUnit::assertEquals('John Smith', $msg['to_name']);
        PHPUnit::assertEquals('john.smith@gmail.com', $msg['to_email']);
    }

    /**
     * @When I go to the activation link
     */
    public function iGoToTheActivationLink()
    {
        $msg = $this->fetchInbox()[0];
        preg_match('/href="(.*?)"/', $msg['html_body'], $urls);
        $this->visitPath($urls[1]);
    }

    /**
     * @Given the activation has expired
     */
    public function theActivationHasExpired()
    {
        Activation::remove(Sentinel::findById(1));
    }
}
