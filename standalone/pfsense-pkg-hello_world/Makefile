PORTNAME=       pfsense-pkg-hello_world
PORTVERSION=    1.0
CATEGORIES=     sysutils
MASTER_SITES=   # none
DISTFILES=      # none
EXTRACT_ONLY=   # none

MAINTAINER=     chris.bradski@gmail.com
COMMENT=        A simple Hello World pfSense package

LICENSE=        APACHE20

USES=           php
#USE_PHP=        sockets session

NO_BUILD=       yes
NO_ARCH=        yes
NO_MTREE=	yes

SUB_FILES=	pkg-install pkg-deinstall
SUB_LIST=	PORTNAME=${PORTNAME}

do-extract:
	${MKDIR} ${WRKSRC}

do-install:
	${MKDIR} ${STAGEDIR}${DATADIR}
	${MKDIR} ${STAGEDIR}${PREFIX}/www
	${MKDIR} ${STAGEDIR}${PREFIX}/etc/rc.d
	${MKDIR} ${STAGEDIR}${PREFIX}/pkg
	${MKDIR} ${STAGEDIR}${PREFIX}/pkg/hello_world
	${MKDIR} ${STAGEDIR}${PREFIX}/share
	${INSTALL_SCRIPT} ${FILESDIR}${PREFIX}/pkg/hello_world.inc \
		${STAGEDIR}${PREFIX}/pkg
	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/hello_world.xml \
		${STAGEDIR}${PREFIX}/pkg
	${INSTALL_SCRIPT} ${FILESDIR}${PREFIX}/pkg/hello_world/post_install_tasks.php \
		${STAGEDIR}${PREFIX}/pkg/hello_world
	${INSTALL_DATA} ${FILESDIR}${PREFIX}/www/hello_world.php \
		${STAGEDIR}${PREFIX}/www
	${INSTALL_SCRIPT} ${FILESDIR}${PREFIX}/etc/rc.d/hello_world_service.sh \
		${STAGEDIR}/usr/local/etc/rc.d/
	${INSTALL_DATA} ${FILESDIR}${PREFIX}/share/pfsense-pkg-hello_world/info.xml \
		${STAGEDIR}${DATADIR}/

	@${REINPLACE_CMD} -i '' -e "s|%%PKGVERSION%%|${PKGVERSION}|" \
		${STAGEDIR}${DATADIR}/info.xml

.include <bsd.port.mk>
