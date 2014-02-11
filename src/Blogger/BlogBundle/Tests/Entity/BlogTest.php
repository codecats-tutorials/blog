<?php

namespace Blogger\BlogBundle\Tests\Entity;

use Blogger\BlogBundle\Entity\Blog;


/**
 * Description of BlogTest
 *
 * @author t
 */
class BlogTest extends \PHPUnit_Framework_TestCase
{
    public function testTitle() 
    {
        $blog = new Blog();
        
        $blog->setTitle('A day with symfony');
        $this->assertEquals('a-day-with-symfony', $blog->getSlug());
    }
    public function testSlug() 
    {
        $blog = new Blog();
        $blog->setSlug('a DAY with symfony');
        
        $this->assertEquals('a-day-with-symfony', $blog->getSlug());
    }
    
    public function testSlugify() 
    {
        $blog = new Blog();
        $this->assertEquals('hello-world', $blog->slugify('Hello World'));
        $this->assertEquals('a-day-with-symfony-2', $blog->slugify('A DaY With symFOny 2'));
        $this->assertEquals('hello-world', $blog->slugify('Hello      World'));
        $this->assertEquals('hello-world', $blog->slugify('Hello     World'));
        $this->assertEquals('hello-world', $blog->slugify('    Hello WoRld    '));
        $this->assertEquals('hello-world', $blog->slugify('Hello world '));
        
    }
}
