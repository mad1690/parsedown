<?php

include 'Parsedown.php';

class Test extends PHPUnit_Framework_TestCase
{
	const provider_dir = 'data/';
	
    /**
     * @dataProvider provider
     */
    public function test_($markdown, $expected)
    {
		$actual = Parsedown::instance()->parse($markdown);
		
		$this->assertEquals($expected, $actual);
    }
	
    public function provider()
    {
		$provider = array();
		
		$DirectoryIterator = new DirectoryIterator(__DIR__.'/'.self::provider_dir);
		
		foreach ($DirectoryIterator as $Item)
		{
			if ($Item->isFile() and $Item->getExtension() === 'md')
			{
				$basename = $Item->getBasename('.md');
				
				$markdown = file_get_contents(__DIR__.'/'.self::provider_dir.$basename.'.md');
				
				if ( ! $markdown)
					continue;
				
				$expected_markup = file_get_contents(__DIR__.'/'.self::provider_dir.$basename.'.html');
				
				$provider []= array($markdown, $expected_markup);
			}
		}
		
		return $provider;
    }
}

