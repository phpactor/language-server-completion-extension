<?php

namespace Phpactor\Extension\LanguageServerCompletion\Tests\Unit;

use LanguageServerProtocol\CompletionList;
use LanguageServerProtocol\InitializeResult;
use LanguageServerProtocol\Position;
use LanguageServerProtocol\TextDocumentItem;
use PHPUnit\Framework\TestCase;
use Phpactor\Container\PhpactorContainer;
use Phpactor\Extension\Completion\CompletionExtension;
use Phpactor\Extension\LanguageServerCompletion\LanguageServerCompletionExtension;
use Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor\Extension\Logger\LoggingExtension;
use Phpactor\FilePathResolverExtension\FilePathResolverExtension;
use Phpactor\LanguageServer\Core\Rpc\RequestMessage;
use Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor\LanguageServer\LanguageServerBuilder;

class LanguageServerCompletionExtensionTest extends TestCase
{
    public function testComplete()
    {
        $container = PhpactorContainer::fromExtensions([
            LoggingExtension::class,
            CompletionExtension::class,
            LanguageServerExtension::class,
            LanguageServerCompletionExtension::class,
            FilePathResolverExtension::class,
        ]);

        $builder = $container->get(LanguageServerExtension::SERVICE_LANGUAGE_SERVER_BUILDER);
        $this->assertInstanceOf(LanguageServerBuilder::class, $builder);
        $dispatcher = $builder->buildDispatcher();
        $responses = $dispatcher->dispatch(new RequestMessage(1, 'initialize', [
            'rootUri' => __DIR__
        ]));
        $responses = iterator_to_array($responses);
        $response = $responses[0];
        $this->assertInstanceOf(ResponseMessage::class, $response);
        $this->assertNull($response->responseError);
        $this->assertInstanceOf(InitializeResult::class, $response->result);

        $document = new TextDocumentItem();
        $document->uri = '/test';
        $document->text = 'hello';
        $position = new Position(1, 1);
        $container->get(LanguageServerExtension::SERVICE_SESSION_MANAGER)->current()->workspace()->open($document);

        $responses = $dispatcher->dispatch(new RequestMessage(1, 'textDocument/completion', [
            'textDocument' => $document,
            'position' => $position,
        ]));
        $responses = iterator_to_array($responses);
        $response = $responses[0];

        $this->assertInstanceOf(ResponseMessage::class, $response);
        $this->assertNull($response->responseError);
        $this->assertInstanceOf(CompletionList::class, $response->result);
    }
}
