<?php declare(strict_types = 1);
namespace FGTCLB\EditorConfig\Tests\Unit\EditorConfig\Rules\File;

use FGTCLB\EditorConfig\EditorConfig\Rules\File\InsertFinalNewLineRule;
use PHPUnit\Framework\TestCase;

class InsertFinalNewLineRuleTest extends TestCase
{

    public function testDetectWrongMissingFinalLineEndingCorrectly()
    {
        $subject = new InsertFinalNewLineRule('dummy/path/file.txt', "All okay\n");
        self::assertTrue($subject->isValid());

        $subject = new InsertFinalNewLineRule('dummy/path/file.txt', "Missing");
        self::assertFalse($subject->isValid());
    }

    public function testFixMissingFinalLineEndingWorks()
    {
        $wrongText = "\n\nMissing";
        $subject = new InsertFinalNewLineRule('dummy/path/file.txt', $wrongText, "\n");
        $result = $subject->fixContent($wrongText);
        self::assertStringEndsWith("\n", $result);
    }
    public function testDoNotTouchIfAllOkay()
    {
        $correctText = "All okay\n";
        $subject = new InsertFinalNewLineRule('dummy/path/file.txt', $correctText, "\n");
        $result = $subject->fixContent($correctText);
        self::assertSame($correctText, $result);
    }
}
