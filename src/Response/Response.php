<?php

namespace HnutiBrontosaurus\BisApiClient\Response;

use Psr\Http\Message\ResponseInterface;


final class Response
{

	const TAG_RESULT = 'result';
	const TAG_RESULT_ATTRIBUTE_ERROR = 'error';


	/** @var ResponseInterface */
	private $httpResponse;

	/** @var array */
	private $data;


	public function __construct(ResponseInterface $httpResponse, \DOMDocument $domDocument)
	{
		$this->httpResponse = $httpResponse;

		$this->parseDom($domDocument);
	}


	/**
	 * @param \DOMDocument $domDocument
	 * @return void
	 */
	private function parseDom(\DOMDocument $domDocument)
	{
		$domFinder = new \DOMXPath($domDocument);
		$rowNodeList = $domFinder->query('*', $domDocument->getElementsByTagName(self::TAG_RESULT)->item(0));

		foreach ($rowNodeList as $rowNode) {
			\assert($rowNode instanceof \DOMNode);

			$row = [];
			foreach ($domFinder->query('*', $rowNode) as $node) {
				\assert($node instanceof \DOMNode);

				$row[$node->nodeName] = $node->nodeValue;
			}

			$this->data[] = $row;
		}
	}


	/**
	 * @return ResponseInterface
	 */
	public function getHttpResponse()
	{
		return $this->httpResponse;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}

}
