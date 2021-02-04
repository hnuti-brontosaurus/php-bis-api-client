<?php

namespace HnutiBrontosaurus\BisApiClient\Response;

use Psr\Http\Message\ResponseInterface;


final class Response
{

	const TAG_RESULT = 'result';
	const TAG_RESULT_ATTRIBUTE_ERROR = 'error';
	const TAG_ATTRIBUTE_ID = 'id';


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
			\assert($rowNode instanceof \DOMElement);

			/** @var array $row */
			$row = [];
			foreach ($domFinder->query('*', $rowNode) as $node) {
				\assert($node instanceof \DOMElement);

				// if there is an ID attribute, use this one a the value as it is numeric representation (thus more technically reliable) of element's content
				$row[$node->nodeName] = $node->hasAttribute(self::TAG_ATTRIBUTE_ID) ?
					$node->getAttribute(self::TAG_ATTRIBUTE_ID)
					:
					$node->nodeValue;
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
