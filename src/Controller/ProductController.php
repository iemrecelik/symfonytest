<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\Cache\CacheKey;
use App\Service\EntitySerializeToJson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\RedisTagAwareAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product', methods:['GET'], name: 'product_list')]
    public function index(EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $client = RedisAdapter::createConnection('redis://localhost');
        $cache = new RedisTagAwareAdapter($client);

        // create a new item by trying to get it from the cache
        $productsCount = $cache->getItem('stats.products_count');

        if (!$productsCount->isHit()) {
            // ... item does not exist in the cache
            dump('fsdfsd');
        }

        // assign a value to the item and save it
        $productsCount->set(4711);
        $cache->save($productsCount);

        // retrieve the cache item
        $productsCount = $cache->getItem('stats.products_count');
        
        // retrieve the value stored by the item
        $total = $productsCount->get();
        // $cache->deleteItem('stats.products_count');

        // dd($total);

        $productRepo = $em->getRepository(Product::class);

        $products = $productRepo->findAll();

        $entitySerializeToJson = new EntitySerializeToJson($products);
        $jsonProdcuts = $entitySerializeToJson->convertNestedEntityToJson($products);

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $jsonProdcuts,
        ]);
    }

    #[Route('/product/create', methods:['GET'], name: 'product_create')]
    public function create(): Response
    {
        $product = new Product();

        $form  = $this->createForm(ProductType::class, $product, [
            'action' => $this->generateUrl('product_store'),
            'method' => 'POST',
        ]);

        return $this->render('product/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/product', methods:['POST'], name: 'product_store')]
    public function store(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_list'); 
        }

        return $this->render('product/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/product/{product}/edit', methods:['GET'], name: 'product_edit')]
    public function edit(Product $product): Response
    {
        $form  = $this->createForm(ProductType::class, $product, [
            'action' => $this->generateUrl('product_update', [
                'product' => $product->getId()
            ]),
            'method' => 'PUT',
        ]);

        return $this->render('product/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/product/{product}', methods:['POST'], name: 'product_update')]
    public function update(Request $request, Product $product, EntityManagerInterface $em): Response
    {
        $form  = $this->createForm(ProductType::class, $product, [
            'action' => $this->generateUrl('product_update', [
                'product' => $product->getId()
            ]),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $em->persist($product);
            $em->flush();

            $this->addFlash(
                'success',
                "{$product->getProdName()} ürünü başarılı bir şekilde kaydedildi."
            );

            return $this->redirectToRoute('product_list'); 
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/product/{product}/delete', methods:['POST'], name: 'product_delete')]
    public function delete(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_list');
    }
}
