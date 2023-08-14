<?php

require_once '../../models/entities/RegexTester.php';
require_once '../../models/entities/Activity.php';
require_once '../../models/entities/Category.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Activity;
use ProjectEvs\Category;


class ActivityTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setId
    public function testSetIdWithFilter() {
        $activity = new Activity();
        $id = 1;
        $activity->setId($id);
        if ($id > 0) {
            $this->assertSame(filter_var($activity->getid(), FILTER_VALIDATE_INT), $activity->getid());
        }
    }

    public function testSetIdNotMatchingWithFilter() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $id = -356;
        $activity->setId($id);
    }

    //Test unitaire sur setAdditionalInformation
    public function testSetAdditionalInformationWithRegex() {
        $activity = new Activity();
        $additionalInformation = 'Lundi/Mardi';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç\/]+$/';
        $this->assertMatchesRegularExpression($pattern, $activity->setAdditionalInformation($additionalInformation));
    }

    public function testSetAdditionalInformationWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $additionalInformation = 426;
        $activity->setAdditionalInformation($additionalInformation);
    }

    public function testSetAdditionalInformationWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $additionalInformation = '?"%!';
        $activity->setAdditionalInformation($additionalInformation);
    }

    public function testNotMatchAdditionalInformationRegex() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $additionalInformation = 'hdjjj-Gl56Msjjs';
        $activity->setAdditionalInformation($additionalInformation);
    }

    //Test unitaire sur setStartDate
    public function testSetStartDateWithCheckdate() {
        $activity = new Activity();
        $date = '12/08/2024';
        $activity->setStartDate($date);
        $this->assertEquals($date, $activity->getStartDate());
    }

    public function testSetStartDateWithExpectedException() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $date = '29/024/2900';
        $activity->setStartDate($date);
    }

    public function testSetStartDateWithWrongFormat() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $date = '04-11-2013';
        $activity->setStartDate($date);
    }

    public function testSetStartDateNotBeforeToday() {
        $activity = new Activity();
        $today = '11/08/2024';
        $date = '12/08/2024';
        $activity->setStartDate($date);
        $this->assertGreaterThanOrEqual($today, $activity->getStartDate());
    }

    //Test unitaire sur setEndDate
    public function testSetEndDateWithCheckdate() {
        $activity = new Activity();
        $date = '12/08/2024';
        $activity->setEndDate($date);
        $this->assertEquals($date, $activity->getEndDate());
    }

    public function testSetEndDateWithExpectedException() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $date = '29/024/2900';
        $activity->setEndDate($date);
    }

    public function testSetEndDateWithWrongFormat() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $date = '04-11-2013';
        $activity->setEndDate($date);
    }

    public function testSetEndDateNotBeforeStartDate() {
        $activity = new Activity();
        $startDate = '12/08/2024';
        $activity->setStartDate($startDate);
        $endDate = '18/08/2024';
        $activity->setEndDate($endDate);
        $this->assertGreaterThan(
            $activity->getStartDate(),
            $activity->compareDates(
                $activity->getStartDate(),
                $activity->getEndDate()
            )
        );
    }

    //Test unitaire sur setStartHour
    public function testSetStartHourWithValideFormat() {
        $activity = new Activity();
        $hour = '10h:30';
        $activity->setStartHour($hour);
        $this->assertEquals($hour, $activity->getStartHour());
    }

    public function testSetStartHourWithWrongFormat() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $hour = '04-ee:2013';
        $activity->setStartHour($hour);
    }

    //Test unitaire sur setStartHour
    public function testSetEndHourWithValideFormat() {
        $activity = new Activity();
        $hour = '10h:30';
        $activity->setEndHour($hour);
        $this->assertEquals($hour, $activity->getEndHour());
    }

    public function testSetEndHourWithWrongFormat() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $hour = '04-ee:2013';
        $activity->setEndHour($hour);
    }

    //Test unitaire sur setPicture
    private static function simulateFileUpload (
        $name,
        $tmpName,
        $error 
    ) {
        $_FILES['userfile'] = [
            'name'     => $name,
            'tmp_name' => $tmpName,
            'error'    => $error,
        ];
    }

    public function testSetPictureErrorAuther() {
        $this->expectException(ExceptionPerso::class);
        $this->simulateFileUpload('invalidFile.txt', '../../assets/test/', UPLOAD_ERR_FORM_SIZE);
        $activity = new Activity();
        $error = 0;
        $fileError = $_FILES['userfile']['error'];
        $file = $_FILES['userfile']['name'];
        $this->assertNotEquals($error, $fileError);
        $activity->setPicture($file);
    }

    public function testSetPictureErrorEqualZero() {
        $this->simulateFileUpload('logoCaf.png', '../../assets/test/', UPLOAD_ERR_OK);
        $activity = new Activity();
        $error = 0;
        $fileError = $_FILES['userfile']['error'];
        $file = $_FILES['userfile']['name'];
        $this->assertEquals($error, $fileError);
        $activity->setPicture($file);
    }

    public function testSetPictureMimeType() {
        $activity = new Activity();
        $path = '../../assets/test/';
        $file = 'logoCaf.png';
        $expectedMimeContentType = ['image/png', 'image/jpeg'];
        $mimeType = mime_content_type($path . $file);
        $activity->setPicture($file);
        $this->assertEquals(in_array($mimeType, $expectedMimeContentType), $mimeType);
    }

    public function testSetPictureBadMimeType() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $file = 'invalidFile.txt';
        $activity->setPicture($file);
    }

    public function testSetPictureDimensions() {
        $activity = new Activity();
        $maxWidth = 1000;
        $maxHeight = 1000;
        $path = '../../assets/test/';
        $file = 'logoCaf.png';
        list($width, $height) = getimagesize($path . $file);
        $this->assertLessThanOrEqual($maxWidth, $width);
        $this->assertLessThanOrEqual($maxHeight, $height);
        $activity->setPicture($file);
    }

    public function testSetPictureBadDimension() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $maxWidth = 1000;
        $maxHeight = 1000;
        $path = '../../assets/test/';
        $file = 'iconCoffee.jpg';
        list($width, $height) = getimagesize($path . $file);
        $this->assertGreaterThan($maxWidth, $width);
        $this->assertGreaterThan($maxHeight, $height);
        $activity->setPicture($file);
    }

    public function testSetPictureSize() {
        $activity = new Activity();
        $maxSize = 10000;
        $path = '../../assets/test/';
        $file = 'logoCaf.png';
        $fileSize = filesize($path . $file);
        $this->assertLessThanOrEqual($maxSize, $fileSize);
        $activity->setPicture($file);
    }

    public function testSetPictureBadSize() {
        $this->expectException(ExceptionPerso::class);
        $activity = new Activity();
        $maxSize = 10000;
        $path = '../../assets/test/';
        $file = 'iconCoffee.jpg';
        $fileSize = filesize($path . $file);
        $this->assertGreaterThan($maxSize, $fileSize);
        $activity->setPicture($file);
    }

    //Test unitaire sur setCategory
    public function testSetCategoryInstanceOf() {
        $activity = new Activity();
        $category = new Category();
        $activity->setCategory($category);
        $this->assertInstanceOf(Category::class, $activity->getCategory());
    }

    public function testSetCategoryNotIntanceOf() {
        $activity = new Activity();
        $category = new Category();
        $activity->setCategory($category);
        $this->assertNotInstanceOf(activity::class, $activity->getCategory());
    }
}