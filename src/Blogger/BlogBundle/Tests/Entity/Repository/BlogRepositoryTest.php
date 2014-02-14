<?php
namespace Blogger\BlogBundle\Tests\Entity\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
/**
 * Description of BlogRepositoryTest
 *
 * @author t
 */
class BlogRepositoryTest extends WebTestCase {
    
    /**
     * @var Blogger\BlogBundle\Repository\BlogRepository
     */
    private $blogRepository;
    
    public function setUp() 
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->blogRepository = $kernel->getContainer()->get('doctrine.orm.entity_manager')
                ->getRepository('BloggerBlogBundle:Blog');
    }
    
    public function testGetTagWeights() 
    {
        $tagWeights = $this->blogRepository->getTagWeights(array(
            'php', 'code', 'symblog', 'blog'
        ));
        $this->assertTrue(count($tagWeights) > 1);
        
        $tagWeights = $this->blogRepository->getTagWeights(array_merge(
            array_fill(0, 10, 'php'), array_fill(0, 2, 'html'), array_fill(0, 6, 'js')
        ));
        
        
        $this->assertEquals(5, $tagWeights['php']);
        $this->assertEquals(3, $tagWeights['js']);
        $this->assertEquals(1, $tagWeights['html']);

        // Test empty case
        $tagsWeight = $this->blogRepository->getTagWeights(array());

        $this->assertEmpty($tagsWeight);
    }
}
