PORTNAME=       pfsense-pkg-pfblockerng_whitelist_rulegen
PORTVERSION=    0.1
CATEGORIES=     net
MASTER_SITES=   # none
DISTFILES=      # none
EXTRACT_ONLY=   # none

MAINTAINER=chris.bradski@gmail.com
COMMENT=        pfSense package pfsense-pkg-pfblockerng_whitelist_rulegen

LICENSE=        APACHE20

USES=           php shebangfix
#USE_PYTHON=		autoplist concurrent distutils

CONFLICTS_INSTALL=      pfsense-pkg-pfblockerng_whitelist_rulegen-devel

NO_BUILD=       yes
NO_MTREE=       yes

SUB_FILES=      pkg-install pkg-deinstall
SUB_LIST=       PORTNAME=${PORTNAME}

do-extract:
	${MKDIR} ${WRKSRC}

do-install:
	${MKDIR} ${STAGEDIR}/etc/inc/priv
	${MKDIR} ${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister
	${MKDIR} ${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/etc/rc.d
	${MKDIR} ${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor
	${MKDIR} ${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/filtersets
	${MKDIR} ${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/pfsense
	${MKDIR} ${STAGEDIR}${PREFIX}/www
	${MKDIR} ${STAGEDIR}${PREFIX}/www/dns_based_ip_whitelister
	${MKDIR} ${STAGEDIR}${DATADIR}

	${INSTALL_DATA} ${FILESDIR}${PREFIX}/share/pfsense-pkg-dns_based_ip_whitelister/info.xml \
		${STAGEDIR}${DATADIR}

	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/dns_based_ip_whitelister/post_install_tasks.php \
		${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister

	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/__init__.py \
		${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor
	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/__main__.py \
		${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor
	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/app.py \
		${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor
	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/filtersets/__init__.py \
		${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/filtersets
	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/filtersets/common.py \
		${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/filtersets
	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/pfsense/__init__.py \
		${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/pfsense
	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/pfsense/api.py \
		${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/pfsense

	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/pfsense/extract_config.php \
		${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/whitelist_monitor/pfsense

	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/dns_based_ip_whitelister/etc/rc.d/svc_whitelist.sh \
		${STAGEDIR}${PREFIX}/pkg/dns_based_ip_whitelister/etc/rc.d

	${INSTALL_DATA} ${FILESDIR}${PREFIX}/www/dns_based_ip_whitelister/whitelist_rulegen_configure.php \
		${STAGEDIR}${PREFIX}/www/dns_based_ip_whitelister

	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/dns_based_ip_whitelister.xml \
		${STAGEDIR}${PREFIX}/pkg

	${MKDIR} ${STAGEDIR}/pkg/dns_based_ip_whitelister/venv

	@${REINPLACE_CMD} -i '' -e "s|%%PKGVERSION%%|${PKGVERSION}|" \
		${STAGEDIR}${DATADIR}/info.xml

.include <bsd.port.mk>