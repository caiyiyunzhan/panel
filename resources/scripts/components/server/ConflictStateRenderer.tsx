import React from 'react';
import { ServerContext } from '@/state/server';
import ScreenBlock from '@/components/elements/ScreenBlock';
import ServerInstallSvg from '@/assets/images/server_installing.svg';
import ServerErrorSvg from '@/assets/images/server_error.svg';
import ServerRestoreSvg from '@/assets/images/server_restore.svg';
import { useTranslation } from "react-i18next";

export default () => {
    const { t } = useTranslation("server");
    const status = ServerContext.useStoreState((state) => state.server.data?.status || null);
    const isTransferring = ServerContext.useStoreState((state) => state.server.data?.isTransferring || false);
    const isNodeUnderMaintenance = ServerContext.useStoreState(
        (state) => state.server.data?.isNodeUnderMaintenance || false
    );

    return status === 'installing' || status === 'install_failed' || status === 'reinstall_failed' ? (
        <ScreenBlock
            title={t("running_installer")}
            image={ServerInstallSvg}
            message={t("server_installing_message")}
        />
    ) : status === 'suspended' ? (
        <ScreenBlock
            title={t("server_suspended")}
            image={ServerErrorSvg}
            message={t("server_suspended_message")}
        />
    ) : isNodeUnderMaintenance ? (
        <ScreenBlock
            title={t("node_under_maintenance")}
            image={ServerErrorSvg}
            message={t("node_under_maintenance_message")}
        />
    ) : (
        <ScreenBlock
            title={isTransferring ? t("transferring") : t("restoring_from_backup")}
            image={ServerRestoreSvg}
            message={
                isTransferring
                    ? t("server_transferring_message")
                    : t("server_restoring_message")
            }
        />
    );
};