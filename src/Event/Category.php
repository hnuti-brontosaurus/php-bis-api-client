<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event;

enum Category: string
{
	case EVP = 'evp'; // výukový program (EVP)
	case EXPERIENTAL = 'experiential'; // zážitková akce
	case INTERNAL = 'internal'; // interní akce
	case INTERNAL_EDUCATIONAL = 'internal_educational'; // vzdělávací pro organizátory HB
	case PRESENTATION = 'presentation'; // prezentační akce
	case PUBLIC_EDUCATIONAL = 'public_educational'; // vzdělávací pro veřejnost
	case SECTION_EVENT = 'section_event'; // oddílová akce
	case SECTION_MEETING = 'section_meeting'; // oddílová schůzka
	case VOLUNTEERING = 'volunteering'; // dobrovolnická akce
}
