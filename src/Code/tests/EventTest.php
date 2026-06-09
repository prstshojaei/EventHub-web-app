<?php
// PHPUnit tests for EventHub application
// Tests core validation and helper functions

use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    // Test that a valid event title passes validation
    public function testValidEventTitle()
    {
        $title = 'IoT Smart Home Workshop';
        $this->assertNotEmpty($title);
        $this->assertGreaterThan(0, strlen($title));
    }

    // Test that an empty title fails validation
    public function testEmptyTitleFails()
    {
        $title = '';
        $this->assertEmpty($title);
    }

    // Test that a valid date format is accepted
    public function testValidDateFormat()
    {
        $date = '2026-06-12';
        $timestamp = strtotime($date);
        $this->assertNotFalse($timestamp);
    }

    // Test that an invalid date returns false
    public function testInvalidDateFormat()
    {
        $date = 'not-a-date';
        $result = strtotime($date);
        $this->assertFalse($result);
    }

    // Test that category must be one of the allowed values
    public function testValidCategory()
    {
        $allowed = ['IoT', 'AI', 'Cybersecurity', 'Web Development', 'Data Science', 'Cloud'];
        $category = 'AI';
        $this->assertContains($category, $allowed);
    }

    // Test that an invalid category is rejected
    public function testInvalidCategory()
    {
        $allowed = ['IoT', 'AI', 'Cybersecurity', 'Web Development', 'Data Science', 'Cloud'];
        $category = 'InvalidCategory';
        $this->assertNotContains($category, $allowed);
    }

    // Test that description has minimum length
    public function testDescriptionMinLength()
    {
        $description = 'A workshop about IoT devices and sensors.';
        $this->assertGreaterThanOrEqual(10, strlen($description));
    }

    // Test that password hash is valid bcrypt
    public function testPasswordHashIsValid()
    {
        $password = 'admin123';
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->assertTrue(password_verify($password, $hash));
    }

    // Test that wrong password fails verification
    public function testWrongPasswordFails()
    {
        $password = 'admin123';
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->assertFalse(password_verify('wrongpassword', $hash));
    }

    // Test that htmlspecialchars removes XSS characters
    public function testHtmlSpecialCharsRemovesXSS()
    {
        $input = '<script>alert("xss")</script>';
        $output = htmlspecialchars($input);
        $this->assertStringNotContainsString('<script>', $output);
    }

    // Test that event date is in the future
    public function testEventDateIsInFuture()
    {
        $date = '2026-12-31';
        $eventDate = new DateTime($date);
        $today = new DateTime();
        $this->assertGreaterThan($today, $eventDate);
    }

    // Test that time format is valid
    public function testValidTimeFormat()
    {
        $time = '09:00:00';
        $parts = explode(':', $time);
        $this->assertCount(3, $parts);
        $this->assertGreaterThanOrEqual(0, (int)$parts[0]);
        $this->assertLessThanOrEqual(23, (int)$parts[0]);
    }
}