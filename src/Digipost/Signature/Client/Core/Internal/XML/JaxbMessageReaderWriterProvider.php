<?php
namespace Digipost\Signature\Client\Core\Internal\XML;

use Digipost\Signature\Client\Core\DocumentFileType;

class JaxbMessageReaderWriterProvider extends AbstractMessageReaderWriterProvider {
	public function isReadable($type, $genericType, $annotations, $mediaType) /* [Class<?> type, Type genericType, Annotation[] annotations, MediaType mediaType]*/
	{
		//return $mediaType->isCompatible(DocumentFileType::XML);
      return TRUE;
	}
	public function readFrom ($type, $genericType, $annotations, $mediaType, $httpHeaders, $entityStream) // [Class<Object> type, Type genericType, Annotation[] annotations, MediaType mediaType, MultivaluedMap<String, String> httpHeaders, InputStream entityStream]
	{
		return $this->unmarshal($entityStream);
	}
	public function isWriteable($type, $genericType, $annotations, $mediaType) /* [Class<?> type, Type genericType, Annotation[] annotations, MediaType mediaType]*/
	{
		//return $mediaType->isCompatible($MediaType->APPLICATION_XML_TYPE);
		return TRUE;
	}
	public function writeTo($o, $type, $genericType, $annotations, $mediaType, $httpHeaders, $entityStream) /* [Object o, Class<?> type, Type genericType, Annotation[] annotations, MediaType mediaType, MultivaluedMap<String, Object> httpHeaders, OutputStream entityStream]*/
	{
		$this->marshal($o, $entityStream);
	}
}

